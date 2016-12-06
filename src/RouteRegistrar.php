<?php

namespace Ipunkt\Laravel\TwoFactorAuthentication;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->router->group([/*'middleware' => ['web', 'auth']*/], function (Router $router) {
            $router->get(config('2fa.routes.enable-token'), [
                'as' => '2fa.enable-token',
                'uses' => config('2fa.handler.enable-token'),
            ]);
            $router->get(config('2fa.routes.disable-token'), [
                'as' => '2fa.disable-token',
                'uses' => config('2fa.handler.disable-token'),
            ]);
            $router->get(config('2fa.routes.input-token'), [
                'as' => '2fa.input-token',
                'uses' => config('2fa.handler.input-token'),
            ]);
            $router->post(config('2fa.routes.validate-token'), [
                'as' => '2fa.validate-token',
                'middleware' => 'throttle:5',
                'uses' => config('2fa.handler.validate-token'),
            ]);
        });
    }
}
