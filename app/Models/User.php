<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Users\Models\User as TypiCmsUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends TypiCmsUser
{
    protected $avatar;

    public function socialAccounts()
    {
        return $this->hasMany('App\Models\UserSocialAccount');
    }

    public static function createNew($data)
    {
        $password = isset($data['password']) ? $data['password'] : md5(time());
        $data['superuser'] = 0;
        $data['email_verified_at'] = null;
        $data['password'] = Hash::make($password);
        $data['activated'] = 1;

        return self::create($data);
    }

    public function getAvatar()
    {
        if (!$this->avatar) {
            foreach ($this->socialAccounts as $social) {
                if (!empty($social->avatar)) {
                    $this->avatar = $social->avatar;
                    break;
                }
            }
        }
        return $this->avatar;
    }

    /**
     * boot method.
     *
     * @return null
     */
    public static function bootHistorable()
    {
        static::created(function (Model $model) {
            $model->writeHistory('created', Str::limit($model->present()->title, 200, '…'), [], $model->toArray());
        });

        static::updated(function (Model $model) {
            $action = 'updated';

            $new = [];
            $old = [];
            foreach ($model->attributes as $key => $value) {
                if ($model->translatable and in_array($key, $model->translatable)) {
                    $values = (array) json_decode($value);
                    $originalValues = (array) json_decode($model->original[$key]);
                    foreach ($values as $locale => $newItem) {
                        if (isset($originalValues[$locale]) && $newItem !== $originalValues[$locale]) {
                            $new[$key][$locale] = $newItem;
                            $old[$key][$locale] = $originalValues[$locale];
                        }
                    }
                } else {
                    $originalValue = isset($model->original[$key]) ? $model->original[$key] : null;
                    if ($value != $originalValue) {
                        $new[$key] = $value;
                        $old[$key] = $originalValue;
                    }
                }
            }

            $model->writeHistory($action, Str::limit($model->present()->title, 200, '…'), $old, $new);
        });

        static::deleted(function (Model $model) {
            $model->writeHistory('deleted', Str::limit($model->present()->title, 200, '…'));
        });
    }
}
