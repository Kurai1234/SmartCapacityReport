<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveAccessPointsStatistic;
use Illuminate\Console\Command;

class GetStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //not working
        // RetrieveAccessPointsStatistic::dispatch();
    }
}
