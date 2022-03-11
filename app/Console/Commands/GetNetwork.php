<?php

namespace App\Console\Commands;
use App\Jobs\Network;
use Illuminate\Console\Command;

class GetNetwork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'network:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the Network Table';

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
        Network::dispatch();

    }
}
