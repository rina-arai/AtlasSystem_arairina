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
            'sex'=> 1,
            'birth_day'=> '2000/09/09',
            'role'=> 4,
            'password'=> bcrypt('yamada1'),
        ]]);

        DB::table('users')->insert([
        [
            'over_name'=> '山田',
            'under_name'=> '花子',
            'over_name_kana'=> 'ヤマダ',
            'under_name_kana'=> 'ハナコ',
            'mail_address'=> 'hanako@gmail.com',
            'sex'=> 2,
            'birth_day'=> '1996/09/09',
            'role'=> 1,
            'password'=> bcrypt('hanako1'),
        ]]);
    }
}
