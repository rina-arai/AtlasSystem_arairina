<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        [
            'over_name'=> '山田',
            'under_name'=> '太郎',
            'over_name_kana'=> 'ヤマダ',
            'under_name_kana'=> 'タロウ',
            'mail_address'=> 'yamada@gmail.com',
            'sex'=> 2,
            'birth_day'=> '1990/09/09',
            'role'=> 0,
            'password'=> bcrypt('yamada1'),
        ]
        ]);
    }
}
