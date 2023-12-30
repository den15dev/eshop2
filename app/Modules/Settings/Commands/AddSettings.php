<?php

namespace App\Modules\Settings\Commands;

use App\Modules\Settings\Models\Setting;
use Illuminate\Console\Command;

class AddSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill DB with main settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->addSettings();
        $this->info('Main settings added to DB');
    }

    private function addSettings(): void
    {
        $records = [
            ['name' => 'email', 'val' => '{"en": "info@eshop2.den15.dev"}'],
            ['name' => 'phone', 'val' => '{"en":"+44 20 2345 6789","ru":"8 (800) 456-78-90","de":"+49 30 2345 6789"}'],
        ];

        Setting::upsert($records, 'name');
    }
}
