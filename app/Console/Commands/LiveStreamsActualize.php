<?php

namespace App\Console\Commands;

use App\Services\TwitchService;
use Illuminate\Console\Command;

/**
 * Чекать статус запущенного стрима. Раз в 10 мин?
 */
class LiveStreamsActualize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live_streams:actualize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check live streams';

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
        $service->checkLiveStreamStatus();

        $this->info('Done');
    }
}
