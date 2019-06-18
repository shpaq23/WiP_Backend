<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    use \App\Models\Uuid;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $filename = 'users.xlsx';
        $arr = excelParser($filename);

        foreach($arr as $ar) {
            $ar['name'] = $ar['first_name'] .' '. $ar['last_name'];
            $ar['password'] = bcrypt($ar['password']);
            $ar['email_verified_at'] = now();
            User::create($ar);
        }
    }
}