<?php

namespace App\Modules\Categories\Commands;

use App\Modules\Categories\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill DB with categories';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->createCategories();
        $this->info('Categories added to DB');
    }

    private function createCategories(): void
    {
        $categories = include_once __DIR__ . '/../Data/categories.php';
        $records = self::buildCategoryList($categories);

        Category::upsert($records, 'id');

        // Fix for PostgreSQL after the upsert: sync the id sequence with the max Pkeys.
        DB::statement('SELECT setval(\'categories_id_seq\', max(id)) FROM categories');
    }


    /**
     * Build a flat associative array for a database
     * from a multidimensional array with nested subcategories.
     *
     * @param array $input_arr
     * @param array $out_arr
     * @return array
     */
    private static function buildCategoryList(array $input_arr, array $out_arr = []): array
    {
        static $id = 1;
        static $parent_id = 0;
        static $level = 1;
        $sort = 1;

        foreach ($input_arr as $cat) {
            $new_cat = [
                'id' => $id,
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'level' => $level,
                'parent_id' => $parent_id,
                'sort' => $sort,
            ];

            array_push($out_arr, $new_cat);
            $id++;
            $sort++;

            if (isset($cat['subcategories'])) {
                $prev_parent_id = $parent_id;
                $parent_id = $id - 1;
                $level++;

                $out_arr = self::buildCategoryList($cat['subcategories'], $out_arr);

                $parent_id = $prev_parent_id;
                $level--;
            }
        }

        return $out_arr;
    }
}
