<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Modules\Temp_JsonbTest\Seeders\FlatProductSeeder;
use App\Modules\Temp_JsonbTest\Seeders\JsonbProductSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        /*
        $this->call([
            JsonbProductSeeder::class,
            FlatProductSeeder::class,
        ]);
        */
    }
}
