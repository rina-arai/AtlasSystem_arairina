<?php

use Illuminate\Database\Seeder;
use App\Models\Posts\Post;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_categories')->insert([
        [
            'main_category_id'=> 1,
            'sub_category'=> '国語',
        ],[
            'main_category_id'=> 1,
            'sub_category'=> '数学',
        ],[
            'main_category_id'=> 1,
            'sub_category'=> '英語',
        ]
        ]);
    }
}
