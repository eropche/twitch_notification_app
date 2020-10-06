<?php

namespace App\Console\Commands;

use App\Services\TwitchService;
use Illuminate\Console\Command;

/**
 * Команда на получение статистики по забаненным и сабам. Раз в день?
 */
class CountStatisticActualize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:actualize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count actualize';

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
        $service->countStatistic();

        $this->info('Done');
    }
}
