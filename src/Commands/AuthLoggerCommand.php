<?php

namespace Spargon\AuthLogger\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Spargon\AuthLogger\AuthLogger;

class AuthLoggerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth-logger:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old records created by the auth logger.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Fetching authentication logs to purge...');

        $days = config('auth-logger.after');
        $from = Carbon::now()->subDays($days)->format('Y-m-d H:i:s');

        $logsDeleted = AuthLogger::where('login_at', '<', $from)->delete();

        if (! $logsDeleted) {
            $this->info('Could not find any old authentication logs to delete.');
        } else {
            $this->info('Authentication logs have been cleared successfully. Total Logs Deleted : '.$logsDeleted);
        }
    }
}
