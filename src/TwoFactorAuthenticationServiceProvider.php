<?php

namespace Ipunkt\Laravel\TwoFactorAuthentication;

use Illuminate\Routing\Router;
use Ipunkt\Laravel\PackageManager\PackageServiceProvider;
use Ipunkt\Laravel\PackageManager\Support\DefinesAliases;
use Ipunkt\Laravel\PackageManager\Support\DefinesConfigurations;
use Ipunkt\Laravel\PackageManager\Support\DefinesMigrations;
use Ipunkt\Laravel\PackageManager\Support\DefinesRouteRegistrar;
use Ipunkt\Laravel\PackageManager\Support\DefinesViews;
use Ipunkt\Laravel\PackageManager\Support\RegistersProviders;

class TwoFactorAuthenticationServiceProvider extends PackageServiceProvider implements
    RegistersProviders,
    DefinesAliases,
    DefinesMigrations,
    DefinesRouteRegistrar,
    DefinesViews,
    DefinesConfigurations
{
    /**
     * returns provider classes it provides
     *
     * @return array|string[]
     */
    public function providers()
    {
        return [
            \PragmaRX\Google2FA\Vendor\Laravel\ServiceProvider::class,
        ];
    }

    /**
     * returns list of alias with alias as key and facade as value
     *
     * @return array
     */
    public function aliases()
    {
        return [
            'Google2FA' => \PragmaRX\Google2FA\Vendor\Laravel\Facade::class
        ];
    }

    /**
     * returns an array of migration paths
     *
     * @return array|string[]
     */
    public function migrations()
    {
        return [
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations'
        ];
    }

    /**
     * defines routes by using the router
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function registerRoutesWithRouter(Router $router)
    {
        (new RouteRegistrar($router))->all();
    }

    /**
     * returns view file paths
     *
     * @return array|string[]
     */
    public function views()
    {
        return [
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views',
        ];
    }

    /**
     * returns an array of config files with their corresponding config_path(name)
     *
     * @return array
     */
    public function configurationFiles()
    {
        return [
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '2fa.php' => $this->namespace(),
        ];
    }

    /**
     * returns namespace of package
     *
     * @return string
     */
    protected function namespace()
    {
        return '2fa';
    }
}