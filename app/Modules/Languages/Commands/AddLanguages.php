<?php

namespace App\Modules\Languages\Commands;

use App\Modules\Languages\Models\Language;
use Illuminate\Console\Command;

class AddLanguages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-languages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill DB with languages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createLanguages();
        $this->info('Languages added to DB');
    }

    private function createLanguages(): void
    {
        $records = [
            ['id' => 'en', 'name' => 'English', 'active' => true, 'default' => true, 'fallback' => true],
            ['id' => 'ru', 'name' => 'Русский', 'active' => true, 'default' => false, 'fallback' => false],
            ['id' => 'de', 'name' => 'Deutsch', 'active' => true, 'default' => false, 'fallback' => false],
        ];

        Language::upsert($records, 'id');
    }
}
