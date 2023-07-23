<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use App\Models\Users\Subjects;

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
