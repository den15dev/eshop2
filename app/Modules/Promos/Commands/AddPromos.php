<?php

namespace App\Modules\Promos\Commands;

use App\Modules\Promos\Models\Promo;
use Illuminate\Console\Command;

class AddPromos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-promos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill DB with promos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createPromos();
        $this->info('Promos added to DB');
    }


    private function createPromos(): void
    {
        $records = include __DIR__ . '/promos.php';

        Promo::upsert($records, 'id');
    }
}
