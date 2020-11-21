<?php

namespace Spargon\AuthLogger;

trait AuthLogable
{
    /**
     * Get the entity's authentications.
     */
    public function auths()
    {
        return $this->morphMany(AuthLogger::class, 'authenticatable')->latest('login_at');
    }

    /**
     * The Auth Logger notifications delivery channels.
     *
     * @return array
     */
    public function notifyAuthLoggerVia()
    {
        return ['mail'];
    }

    /**
     * Get the entity's last login at.
     */
    public function lastLoginAt()
    {
        return optional($this->auths()->first())->login_at;
    }

    /**
     * Get the entity's last login ip address.
     */
    public function lastLoginIp()
    {
        return optional($this->auths()->first())->ip_address;
    }

    /**
     * Get the entity's previous login at.
     */
    public function previousLoginAt()
    {
        return optional($this->auths()->skip(1)->first())->login_at;
    }

    /**
     * Get the entity's previous login ip.
     */
    public function previousLoginIp()
    {
        return optional($this->auths()->skip(1)->first())->ip_address;
    }
}
