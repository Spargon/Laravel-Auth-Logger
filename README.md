![](https://banners.beyondco.de/Laravel-Auth-Logger.png?theme=light&packageName=spargon%2Flaravel-auth-logger&pattern=circuitBoard&style=style_2&description=Log+and+notify+users+whenever+they+access+from+new+a+device.&md=1&showWatermark=0&fontSize=100px&images=lock-closed)

[![GitHub release](https://img.shields.io/github/release/spargon/laravel-auth-logger.svg?style=for-the-badge&&colorB=7E57C2)](https://packagist.org/packages/spargon/laravel-auth-logger)
[![GitHub issues](https://img.shields.io/github/issues/Spargon/Laravel-Auth-Logger.svg?style=for-the-badge)](https://github.com/Spargon/Laravel-Auth-Logger/issues)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=for-the-badge&&colorB=F27E40)](license.md)
[![Total Downloads](https://img.shields.io/packagist/dt/spargon/laravel-auth-logger.svg?style=for-the-badge)](https://packagist.org/packages/spargon/laravel-auth-logger)
![StyleCI](https://github.styleci.io/repos/314730871/shield?branch=main)

Laravel Auth Logger stores user authentication logs and sends out notifications whenever a user logs in from a new system.

## Installation

> Laravel Auth Logger requires PHP 7.0+ and currently supports Laravel 7, 8 & 9.

You can install the package via composer:

```bash
composer require spargon/laravel-auth-logger
```

After installing the **Laravel-Auth-Logger** package, you need run the install command which will take care of everything you need to get started. Type the following artisan command in your console:

```bash
php artisan auth-logger:install
```
This will publish the `config/auth-logger.php` file, publish the necessary migration files and ask you for permission to run said migrations.

![Install Command Sample](install-command.jpg)

Once installed, you need to add the **`AuthLogable`** and **`Notifiable`** traits to your authenticatable model (by default its, `App\Models\User` model). These traits provides you with various methods to get the data generated by the auth logger, such as last login time, last login IP address, and sets the channels to notify the user when they login from a new device:

``` php
use Illuminate\Notifications\Notifiable;
use Spargon\AuthLogger\AuthLogable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, AuthLogable;
}
```

## Usage

Get all the authentication logs for a user:

``` php
User::find(1)->auths;
```

Get the user's last login info (includes the current session if the user is logged in):

```php
User::find(1)->lastLoginAt(); [or] auth()->user()->lastLoginAt()

User::find(1)->lastLoginIp(); [or] auth()->user()->lastLoginIp()
```

Get the user's previous login time & ip address (ignoring the current login log):

```php
User::find(1)->previousLoginAt(); [or] auth()->user()->previousLoginAt()

User::find(1)->previousLoginIp(); [or] auth()->user()->lapreviousLoginIpstLoginAt()
```

### Send New Device Alert Notification

Notifications may be sent on the `mail`, or/and the `slack` channels. By default AuthLogger will send a notification via the mail driver (provided you have enabled `notify` in `config/auth-logger.php` file).

You can define `notifyAuthLoggerVia` method on the User's Model to determine which channels the notification should be sent to:

```php
/**
 * The Auth Logger notifications delivery channels.
 *
 * @return array
 */
public function notifyAuthLoggerVia()
{
    return ['mail', 'slack'];
}
```

### Slack Notifications & Customiziations

**Note:** If you want to use the `slack` notification channel, you need to install the `laravel/slack-notification-channel` package first otherwise your app will throw a `Driver not supported` error. Be sure to go through the Laravel docs for Slack Pre-requisites [here.](https://laravel.com/docs/8.x/notifications#slack-prerequisites)

You also need to generate a Slack Incoming Webhook from [here](https://slack.com/services/new/incoming-webhook) and then add the generated webhook to your authenticatable model (usually the User) as such:

```php
/**
 * Route notifications for the Slack channel.
 *
 * @param  \Illuminate\Notifications\Notification  $notification
 * @return string
 */
public function routeNotificationForSlack($notification)
{
    return 'https://hooks.slack.com/services/T01D8HUCU4.....'; // replace this with the webhook you receive from Slack
}
```

##### Customizing Messages

In `config/auth-logger.php` file, you can customize the name of the `Sender`, the `Channel` to receive the notifications on & the `Icon` to show on the notification.

By default all slack messages will be sent to the `#general` channel.
Slack Sample Image | Mail Sample Image
:-------------------------:|:-------------------------:
![](slack-sample.png)  |  ![](mail-sample.png)

### Disabling Notifications
Of course you can disable notifications by setting the `notify` option in your `config/auth-logger.php` configuration file to `false`:

```php
'notify' => env('AUTH_LOGGER_NOTIFY', false),
```

### User Agent Parser

This package uses the `jenssegers/agent` package to parse the user's user-agent when sending the alert notification. Take a look at their docs [here](https://github.com/jenssegers/agent) to learn how to use it in your app (ex: in your logs table).

### Delete logs after a while

You may clear the old authentication log records using the `auth-logger:clear` Artisan command:

    php artisan auth-logger:clear

Records that are older than the number of days specified in the `older` option in your `config/auth-logger.php` will be deleted when you run the above command:

```php
'older' => 31,
```

## Optional Files

You can publish the New Device Alert Email view using the command below:

```bash
php artisan vendor:publish  --tag=auth-logger-views
```

You can also publish the translations file used by the auth-logger using the command below:

```bash
php artisan vendor:publish  --tag=auth-logger-translations
```
*These are optional files. You don't need to publish them for the package to work. They exist only for cases where you want to make any changes to the files yourself.*

#### Change Database Table Name 

If you want to change the name of the auth-logger table, you can do so by changing the vaule of `table_name` in the `config/auth-logger.php` file (this step is optional - you must also update the table name in the migrations/database to reflect the same).

## Experimental (dev-geoip)

Currently we are experimenting with an implention of Location Tagging (using GeoIP package from Torann). You can checkout the `geoip` branch to play around with it or get the dev-geoip release from packagist using `composer require spargon/laravel-auth-logger:dev-geoip`

*This is an experimental release of location tagging. Accuracy is not 100% guaranteed. Use it at your own risk. PS> This experimental version does not contain the install command.*

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Moinuddin S. Khaja](https://github.com/TechTailor)
- [Yaakov Dahan](https://github.com/yakidahan) ([Original Source Package](https://github.com/yadahan/laravel-authentication-log))
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
