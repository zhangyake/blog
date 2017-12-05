<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'name'=>'技术',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('types')->insert([
            'name'=>'读书笔记',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('types')->insert([
            'name'=>'生活感悟',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('types')->insert([
            'name'=>'文艺',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
       
    }
}
