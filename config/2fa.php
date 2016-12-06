<?php

return [
    /**
     * route paths for all supported routes
     */
    'routes' => [
        /**
         * Route path for route '2fa.enable-token'
         */
        'enable-token' => '/2fa/enable',

        /**
         * Route path for route '2fa.disable-token'
         */
        'disable-token' => '/2fa/disable',

        /**
         * Route path for route '2fa.input-token'
         */
        'input-token' => '/2fa/validate',

        /**
         * Route path for route '2fa.validate-token' (POST)
         */
        'validate-token' => '/2fa/validate',
    ],

    /**
     * request handler
     */
    'handler' => [
        /**
         * enable token request handler
         */
        'enable-token' => 'Ipunkt\Laravel\TwoFactorAuthentication\Http\Controllers\Google2FAController@enableTwoFactor',

        /**
         * disable token request handler
         */
        'disable-token' => 'Ipunkt\Laravel\TwoFactorAuthentication\Http\Controllers\Google2FAController@disableTwoFactor',

        /**
         * display input token form
         */
        'input-token' => 'Ipunkt\Laravel\TwoFactorAuthentication\Http\Controllers\Google2FAController@getValidateToken',

        /**
         * validate input token form
         */
        'validate-token' => 'Ipunkt\Laravel\TwoFactorAuthentication\Http\Controllers\Google2FAController@postValidateToken',
    ],

    /**
     * views for controller
     */
    'views' => [
        /**
         * what view should be displayed on enable-token request handler
         */
        'enable-token' => '2fa::enableTwoFactor',

        /**
         * what view should be displayed on disable-token request handler
         */
        'disable-token' => '2fa::disableTwoFactor',

        /**
         * what view should be displayed on input-token request handler
         */
        'input-token' => '2fa::validate',
    ],

    /**
     * where do we redirect to after successful login
     * (should be the same like LoginController::$redirectTo)
     */
    'redirect' => '/home',

    /**
     * where do we redirect to on missing 2fa token
     * (should be a login form)
     */
    'redirect-on-missing-2fa-token' => '/login',
];