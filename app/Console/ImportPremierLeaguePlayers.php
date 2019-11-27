<?php

namespace App\Console;

use App\Services\Client\PremierLeague\PremierLeagueClientService;
use App\Services\PlayerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportPremierLeaguePlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import players every minute';

    /**
     * @var PremierLeagueClientService
     */
    protected $clientService;

    /**
     * @var PlayerService
     */
    protected $playerService;

    /**
     * Create a new command instance.
     *
     * ImportPlayers constructor.
     * @param PremierLeagueClientService $clientService
     * @param PlayerService $playerService
     */
    public function __construct(PremierLeagueClientService $clientService, PlayerService $playerService)
    {
        parent::__construct();
        $this->clientService = $clientService;
        $this->playerService = $playerService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            // initiate the api call
            $playerList = $this->clientService->fetchPlayers();
            $this->playerService->syncPlayers($playerList, config('clients.premier_league.player.fetch_min_data'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}