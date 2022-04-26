<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CleanupAccessPoints;
use Spatie\Backup\Tasks\Cleanup\CleanupJob;

class CleanUpAccessPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accesspoint:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans APs that are offline';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CleanupAccessPoints::dispatch();
        // return 0;
    }
}
