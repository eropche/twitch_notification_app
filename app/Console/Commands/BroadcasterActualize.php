<?php

namespace App\Console\Commands;

use App\Services\TwitchService;
use Illuminate\Console\Command;

class BroadcasterActualize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcasters:actualize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualize broadcasers info';

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
    public function handle(TwitchService $service)
    {
        $service->broadcastersActualize();

        $this->info('Done');
    }
}
