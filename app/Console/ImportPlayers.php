<?php

namespace App\Console;

use App\Services\PlayerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportPlayers extends Command
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
     * @var PlayerService
     */
    protected $playerService;

    /**
     * Create a new command instance.
     *
     * ImportPlayers constructor.
     * @param PlayerService $playerService
     */
    public function __construct(PlayerService $playerService)
    {
        parent::__construct();
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
            $this->playerService->syncPlayers();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}