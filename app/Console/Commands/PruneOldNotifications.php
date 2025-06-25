<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PruneOldNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skoolio:prune-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete read notifications older than one month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Pruning old read notifications...');

        $cutoffDate = Carbon::now()->subMonth();

        $deletedCount = \Illuminate\Notifications\DatabaseNotification::whereNotNull('read_at')
            ->where('read_at', '<', $cutoffDate)
            ->delete();

        $this->info("Done. Deleted {$deletedCount} old notifications.");
    }
}
