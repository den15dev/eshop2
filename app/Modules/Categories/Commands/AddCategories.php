<?php

namespace App\Modules\Categories\Commands;

use App\Console\Commands\BaseCommand;
use App\Modules\Categories\Models\Category;
use Illuminate\Support\Facades\DB;

class AddCategories extends BaseCommand
{
    protected $signature = 'app:add-categories';

    protected $description = 'Fill DB with categories';


    public function handle(): void
    {
        $categories = include __DIR__ . '/../Data/categories.php';
        $records = self::buildCategoryList($categories);

        if (Category::count() == 0) {
            foreach ($records as $record) {
                Category::create($record);
            }

            // Fix for PostgreSQL: sync the id sequence with the max Pkeys.
            DB::statement('SELECT setval(\'categories_id_seq\', max(id)) FROM categories');

            $this->info('Categories added to main DB');

        } else {
            echo 'Categories already exist in main DB' . PHP_EOL;
        }

        if (parent::$test_db_connection) {
            if (Category::on(parent::$test_db_connection)->count() == 0) {
                foreach ($records as $record) {
                    Category::on(parent::$test_db_connection)->create($record);
                }

                DB::connection(parent::$test_db_connection)
                    ->statement('SELECT setval(\'categories_id_seq\', max(id)) FROM categories');

                $this->info('Categories added to testing DB');

            } else {
                echo 'Categories already exist in testing DB' . PHP_EOL;
            }
        }
    }


    /**
     * Build a flat associative array for a database
     * from a multidimensional array with nested subcategories.
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

            $out_arr[] = $new_cat;
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
