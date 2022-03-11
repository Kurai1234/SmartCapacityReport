<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\Tower;
class GetTower extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tower:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To populate the tower table';

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
        Tower::dispatch();
        return 0;
    }
}
