<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate all SKUs, products, specs, attributes, variants, and all anchor tables.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table_list = [
            'sku_variant',
            'sku_specification',
            'variants',
            'attributes',
            'skus',
            'products',
            'specifications',
        ];

        foreach ($table_list as $table) {
            DB::statement('TRUNCATE TABLE public.' . $table . ' RESTART IDENTITY CASCADE');
            echo 'Table "' . $table . '" truncated' . "\n";
        }

        echo 'Before seedeng DB, DELETE ALL OLD PRODUCT IMAGES MANUALLY!' . "\n";
    }
}
