# Two Factor Authentication

[![Total Downloads](https://poser.pugx.org/ipunkt/laravel-two-factor-authentication/d/total.svg)](https://packagist.org/packages/ipunkt/laravel-two-factor-authentication)
[![Latest Stable Version](https://poser.pugx.org/ipunkt/laravel-two-factor-authentication/v/stable.svg)](https://packagist.org/packages/ipunkt/laravel-two-factor-authentication)
[![Latest Unstable Version](https://poser.pugx.org/ipunkt/laravel-two-factor-authentication/v/unstable.svg)](https://packagist.org/packages/ipunkt/laravel-two-factor-authentication)
[![License](https://poser.pugx.org/ipunkt/laravel-two-factor-authentication/license.svg)](https://packagist.org/packages/ipunkt/laravel-two-factor-authentication)

## Introduction

This package adds 2FA (Two Factor Authentication) to your laravel application.

## Installation

Just install the package by adding to composer requirements

	composer require ipunkt/laravel-two-factor-authentication

and add the Service Provider in your `config/app.php`

	\Ipunkt\Laravel\TwoFactorAuthentication\ServiceProvider::class,

After adding the provider the database migration should run

	php artisan migrate


## Setup

### User Model Trait

The package adds a `google2fa_secret` column to your users table. This can be null, but should hold the secret key, being generated with the help of a trait: `Ipunkt\Laravel\TwoFactorAuthentication\TwoFactorSupport`

This trait has to be added to the authorization based user model class.

### Authentication Controller

The `Ipunkt\Laravel\TwoFactorAuthentication\AuthenticatesWith2FA` trait overrides the `authenticated` method within the `LoginController`. So please update your LoginController

	use App\Http\Controllers\Controller;
    use Ipunkt\Laravel\TwoFactorAuthentication\AuthenticatesWith2FA;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;

	class LoginController extends Controller
    {
    	use AuthenticatesUsers,
                AuthenticatesWith2FA {
                AuthenticatesWith2FA::authenticated insteadof AuthenticatesUsers;
            }
		//...
	}

So we can interact with the user after authenticating with user credentials and display a TOTP field to get the Authenticator App displayed One-Time-Token.

## Customizing Package Content

### Config

You can change config settings by publishing config file

	$> php artisan vendor:publish --provider="Ipunkt\Laravel\TwoFactorAuthentication\ServiceProvider" --tag=config

and edit `/config/2fa.php` to suit your needs.

### Views

You can change delivered views by publishing view files

	$> php artisan vendor:publish --provider="Ipunkt\Laravel\TwoFactorAuthentication\ServiceProvider" --tag=view

and edit views in `/resources/views/vendor/2fa`.

### Migrations

You can change the packaged migrations by publishing migrations

	$> php artisan vendor:publish --provider="Ipunkt\Laravel\TwoFactorAuthentication\ServiceProvider" --tag=migrations

and edit migrations in `/database/migrations`.

## License

Two Factor Authentication is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
