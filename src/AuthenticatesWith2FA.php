<?php

namespace Ipunkt\Laravel\TwoFactorAuthentication;

use Auth;
use Cache;
use Illuminate\Http\Request;
use Ipunkt\Laravel\TwoFactorAuthentication\Http\Requests\ValidateSecretRequest;

trait AuthenticatesWith2FA
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function getValidateToken()
    {
        if (session('2fa:user:id')) {
            return view(config('2fa.views.input-token'));
        }

        return redirect(config('2fa.redirect-on-missing-2fa-token'));
    }

    /**
     *
     * @param  \Ipunkt\Laravel\TwoFactorAuthentication\Http\Requests\ValidateSecretRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postValidateToken(ValidateSecretRequest $request)
    {
        //get user id and create cache key
        $userId = $request->session()->pull('2fa:user:id');
        $key = $userId . ':' . $request->totp;

        //use cache to store token to blacklist
        Cache::add($key, true, 4);

        //login and redirect user
        Auth::loginUsingId($userId);

        return redirect()->intended(config('2fa.redirect'));
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->google2fa_secret) {
            Auth::logout();

            $request->session()->put('2fa:user:id', $user->id);

            return redirect()->route('2fa.input-token');
        }

        return redirect()->intended(config('2fa.redirect'));
    }
}