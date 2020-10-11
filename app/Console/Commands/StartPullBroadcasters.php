<?php

namespace App\Console\Commands;

use App\InterestBroadcaster;
use Illuminate\Console\Command;

class StartPullBroadcasters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcasters:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start pull broadcasters';

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
     */
    public function handle()
    {
        // Example :)
        $names = [
            'lasqa', 'honeymad', 'segall', 'usachman', 'melharucos', 'arrowwoods', 'c_a_k_e', 'odinezy'
        ];
        foreach ($names as $name) {
            InterestBroadcaster::create(['name' => $name]);
        }

        $this->info('Done');
    }
}
