<?php

namespace Spargon\AuthLogger\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Jenssegers\Agent\Agent;
use Spargon\AuthLogger\AuthLogger;

class NewDeviceAlert extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The authentication log.
     *
     * @var \Spargon\AuthLogger\AuthLogger
     */
    public $authLogger;

    /**
     * Jenssegers agent.
     *
     * @var \Jenssegers\Agent\Agent
     */
    public $agent;

    /**
     * User's browser retrived from the user agent.
     */
    public $browser;

    /**
     * User's platform retrived from the user agent.
     */
    public $platform;

    /**
     * User's device type retrived from the user agent.
     */
    public $deviceType;

    /**
     * User's device name (only for mobile devices).
     */
    public $deviceName = '';

    /**
     * User's Location (if enabled in config).
     */
    public $location;

    /**
     * Create a new notification instance.
     *
     * @param  \Spargon\AuthLogger\AuthLogger  $authLogger
     * @return void
     */
    public function __construct(AuthLogger $authLogger)
    {
        $this->authLogger = $authLogger;

        // Parsing the user agent
        $this->agent = new Agent();
        $this->agent->setUserAgent($authLogger->user_agent);
        $this->browser = $this->agent->browser();
        $this->platform = $this->agent->platform();

        // Check device type and fetch device name for mobile.
        if ($this->agent->isMobile()) {
            $this->deviceType = 'mobile';
            $this->deviceName = $this->agent->device();
        } elseif ($this->agent->isTablet()) {
            $this->deviceType = 'tablet';
        } elseif ($this->agent->isDesktop()) {
            $this->deviceType = 'desktop';
        }

        if(config('auth-logger.location_tagging')) {
            $this->location = geoip($this->authLogger->ip_address);
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->notifyAuthLoggerVia();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::get('auth-logger::messages.subject'))
            ->markdown('auth-logger::emails.new-device-alert', [
                'account' => $notifiable,
                'time' => $this->authLogger->login_at,
                'ipAddress' => $this->authLogger->ip_address,
                'browser' => $this->browser,
                'browserVersion' => $this->agent->version($this->browser),
                'platform' => $this->platform,
                'platformVersion' => $this->agent->version($this->platform),
                'deviceType' => $this->deviceType,
                'deviceName' => $this->deviceName,
                'location' => $this->location
            ]);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from(config('auth-logger.slack.from'))
            ->to(config('auth-logger.slack.channel'))
            ->image(config('auth-logger.slack.image'))
            ->warning()
            ->content(Lang::get('auth-logger::messages.content', ['app' => config('app.name')]))
            ->attachment(function ($attachment) use ($notifiable) {
                $attachment
                    ->fields([
                        'Account' => $notifiable->email,
                        'Time' => $this->authLogger->login_at->toCookieString(),
                        'IP Address' => $this->authLogger->ip_address,
                        'Browser' => $this->browser.' ('.$this->agent->version($this->browser).')',
                        'Platform' => $this->platform.' ('.$this->agent->version($this->platform).')',
                        'URL' => config('app.url'),
                        'Location' => $this->location ? $this->location->city .' ('.$this->location->state .'), ' . $this->location->country : 'Disabled',
                    ]);
            });
    }
}
