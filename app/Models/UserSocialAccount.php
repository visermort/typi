<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserSocialAccount extends Model
{
    use Notifiable;


    public $table="user_social_accounts";

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function userByProvider($provider, $providerUser)
    {
        $socialUser = self::where(['provider' => $provider, 'provider_user_id' => $providerUser->id])->first();
        if (!$socialUser) {
            $socialUser = new self();
            $socialUser->provider = $provider;
            $socialUser->provider_user_id = $providerUser->id;
            $socialUser->nickname = $providerUser->getNickname();
            $socialUser->name = $providerUser->getName();
            $socialUser->email = $providerUser->getEmail();
            $socialUser->avatar = $providerUser->getAvatar();

            if ($socialUser->email) {
                $user = User::where(['email' => $socialUser->email])->first();
                if (!$user) {
                    $user = User::createNew([
                        'first_name' => $socialUser->name,
                        'email' => $socialUser->email,
                    ]);
                }
                $socialUser->user_id = $user->id;
            }
            $socialUser->save();
        }
        if ($socialUser->user && !empty($providerUser->email)) {
            $user = User::where(['email' => $providerUser->email])->first();
            if ($user) {
                $socialUser->user_id = $user->id;
                $socialUser->save();
            }
        }
        return $socialUser;
    }

    public function verifyEmail($request)
    {
        if ($request->get('token') == sha1($this->email_verify_token)) {
            $this->email_verified_at = $this->freshTimestamp();

            $user = User::where(['email' => $this->email])->first();
            if (!$user) {
                $user = User::createNew([
                    'first_name' => $this->name,
                    'email' => $this->email,
                ]);
            }
            $user->markEmailAsVerified();
            $this->user_id = $user->id;
            $this->save();
            return $user;
        }
    }

}
