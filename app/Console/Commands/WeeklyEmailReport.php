<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\WeeklyMailReport;

class WeeklyEmailReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weeklymailreport:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the last Week Emails';

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

         WeeklyMailReport::dispatch();
    }
}
