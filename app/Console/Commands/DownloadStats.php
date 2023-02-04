<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DownloadStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volley:download-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scarica dal sito della federazione i dati sul campionato';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $this->info('- Start job (' . $this->signature . '): ' . $now);

        // TODO: Eseguire operazioni per scaricate le statistiche

        return Command::SUCCESS;
    }
}
