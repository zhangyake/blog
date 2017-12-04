<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'name'=>'admin',
            'email'=>'jaak@126.com',
            'password'=>bcrypt('admin'),
            'is_admin'=>1,
            'gender'=>'male',
            'desc'=>'admin user',
            'date'=>\Carbon\Carbon::now(),
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }
}
