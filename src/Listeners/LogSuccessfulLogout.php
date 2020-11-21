<?php

namespace Spargon\AuthLogger\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spargon\AuthLogger\AuthLogger;

class LogSuccessfulLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if ($event->user) {
            $user = $event->user;
            $ip = $this->request->ip();
            $userAgent = $this->request->userAgent();
            $authLogger = $user->auths()->whereIpAddress($ip)->whereUserAgent($userAgent)->first();

            if (! $authLogger) {
                $authLogger = new AuthLogger([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                ]);
            }

            $authLogger->logout_at = Carbon::now();

            $user->auths()->save($authLogger);
        }
    }
}
