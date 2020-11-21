<?php

namespace Spargon\AuthLogger;

use Illuminate\Database\Eloquent\Model;

class AuthLogger extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_logs';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['authenticatable_id', 'authenticatable_type'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    /**
     * Get the authenticatable entity that the authentication log belongs to.
     */
    public function authenticatable()
    {
        return $this->morphTo();
    }
}
