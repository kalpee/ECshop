<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name' => 'トップス',
                'sort_order' => 1,
            ],
            [
                'name' => 'ボトムス',
                'sort_order' => 2,
            ],
            [
                'name' => 'アクセサリー',
                'sort_order' => 3,
            ],
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => 'シャツ',
                'sort_order' => 1,
                'primary_category_id' => 1
            ],
            [
                'name' => 'コート',
                'sort_order' => 2,
                'primary_category_id' => 1
            ],
            [
                'name' => 'パーカー',
                'sort_order' => 3,
                'primary_category_id' => 1
            ],
            [
                'name' => 'パンツ',
                'sort_order' => 4,
                'primary_category_id' => 2
            ],
            [
                'name' => 'ショートパンツ',
                'sort_order' => 5,
                'primary_category_id' => 2
            ],
            [
                'name' => 'スカート',
                'sort_order' => 6,
                'primary_category_id' => 2
            ],
        ]);
    }
}
