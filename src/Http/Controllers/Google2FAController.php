<?php

namespace Ipunkt\Laravel\TwoFactorAuthentication\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use DonePM\TwoFactorAuthentication\AuthenticatesWith2FA;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class Google2FAController extends Controller
{
    use ValidatesRequests,
        AuthenticatesWith2FA;

    /**
     * constructing Google2FAController
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function enableTwoFactor(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $secret = $user->generateTwoFactorSecret();

        $imageDataUri = \Google2FA::getQRCodeInline(
            $request->getHttpHost(),
            $user->email,
            $secret,
            200
        );

        return view(config('2fa.views.enable-token'), ['image' => $imageDataUri, 'secret' => $secret]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function disableTwoFactor(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->google2fa_secret = null;
        $user->save();

        return view(config('2fa.views.disable-token'));
    }
}