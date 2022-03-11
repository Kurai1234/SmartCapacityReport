<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\AccessPoint;
class GetAccessPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accesspoint:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates the access point information';

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
    AccessPoint::dispatch();        
        return 0;
    }
}
