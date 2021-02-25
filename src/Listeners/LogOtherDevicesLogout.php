<?php

namespace Spargon\AuthLogger\Listeners;

use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spargon\AuthLogger\AuthLogger;

class LogOtherDevicesLogout
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
    public function handle(OtherDeviceLogout $event)
    {
        if ($event->user) {
            $currentUser = $event->user;
            $currentUserIp = $this->request->ip();
            $currentUserAgent = $this->request->userAgent();
            $currentAuthLog = $currentUser->auths()->whereIpAddress($currentUserIp)->whereUserAgent($currentUserAgent)->first();

            if (!$currentAuthLog) {
                $currentAuthLog = new AuthLogger([
                    'ip_address' => $currentUserIp,
                    'user_agent' => $currentUserAgent,
                ]);
            }

            foreach ($currentUser->auths as $authLog) {
                if ($authLog->id != $currentAuthLog->id) {
                    $authLog->logout_at = Carbon::now();
                    $authLog->save();
                }
            }
        }
    }
}