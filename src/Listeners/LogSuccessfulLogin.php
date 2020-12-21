<?php

namespace Spargon\AuthLogger\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spargon\AuthLogger\AuthLogger;
use Spargon\AuthLogger\Notifications\NewDeviceAlert;

class LogSuccessfulLogin
{
    /**
     * The request.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Create the event listener.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        $ip = $this->request->ip();
        $userAgent = $this->request->userAgent();
        $known = $user->auths()->whereIpAddress($ip)->whereUserAgent($userAgent)->first();
        $newUser = $user->created_at->diffInMinutes(Carbon::now()) < 1;

        $authLogger = new AuthLogger([
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'login_at' => Carbon::now(),
        ]);

        $user->auths()->save($authLogger);

        if (! $known && ! $newUser && config('auth-logger.notify')) {
            $user->notify(new NewDeviceAlert($authLogger));
        }
    }
}
