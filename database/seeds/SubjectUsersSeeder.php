<?php

use Illuminate\Database\Seeder;

class SubjectUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subject_users')->insert([
        [
            'user_id'=> '1',
            'subject_id'=> '1',
        ]
        ]);
    }

}
