<?php

namespace App\Console\Commands;

use App\Services\TwitchService;
use Illuminate\Console\Command;

/**
 * Команда на чек стримов. Раз в 3 мин?
 */
class HistoryActualize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history:actualize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check start streams';

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
        $service->checkStartStream();

        $this->info('Done');
    }
}
