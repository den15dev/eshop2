<?php

namespace App\Console\Commands;

use App\Models\Language;
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
        $templates = [
            ['id' => 'en', 'name' => 'English', 'active' => true, 'default' => true, 'fallback' => true],
            ['id' => 'ru', 'name' => 'Русский', 'active' => true, 'default' => false, 'fallback' => false],
            ['id' => 'de', 'name' => 'Deutsch', 'active' => true, 'default' => false, 'fallback' => false],
        ];

        Language::upsert($templates, 'id');
    }
}
