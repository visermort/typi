<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\UserSocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SocialEmailVerification;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    /**
     * @param $provider
     * @return mixed
     */
    public function login($provider)
    {
        return Socialite::with($provider)->redirect();
    }

    /**
     * @param SocialAccountService $service
     * @param $provider
     * @return mixed
     */
    public function callback($provider, Request $request)
    {

        $driver   = Socialite::driver($provider);
        $providerUser = $driver->user();
        //dd($providerUser);
        $socialUser = UserSocialAccount::userByProvider($provider, $providerUser);
        if ($socialUser->user) {
            //пользователь есть
            Auth::login($socialUser->user, true);
            return redirect()->intended('/');
        } else {
            //юсера пока нет нужен email
            $request->session()->put('social_user_id', $socialUser->id);
            return redirect()->action('\App\Http\Controllers\Auth\SocialController@emailRequest');
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function emailRequest(Request $request)
    {
        if ($request->isMethod('post')) {
            $socialUser = UserSocialAccount::find($request->session()->get('social_user_id'));
            if (!$socialUser) {
                return redirect()->action('TypiCMS\Modules\Users\Http\Controllers\LoginController@showLoginForm');
            }
            //$request->session()->put('social_user_id', null);
            $this->validate($request, ['email' => 'required|email']);
            $socialUser->email = $request->email;
            $socialUser->email_verify_token = $token = Str::random(32);
            $socialUser->save();

            $socialUser->notify(new SocialEmailVerification());

            return redirect()->action('\App\Http\Controllers\Auth\SocialController@emailSend')->with('send', true);
        }

        return view('auth.email_request', [
            'message' => __('We need your email to register'),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function emailVerify(Request $request)
    {
        $socialUser = UserSocialAccount::where(['id' => $request->get('id')])->first();
        if (!$socialUser || !$user = $socialUser->verifyEmail($request)) {
            return redirect(url('/'))->with('error', __('Error verifiing E-mail'));
        }
        Auth::login($user, true);
        return redirect(url('/'))->with('verified', true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function emailSend()
    {
        return view('auth.email_send');
    }

}
