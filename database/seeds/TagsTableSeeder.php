<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'name'=>'JS',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('tags')->insert([
            'name'=>'Nginx',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('tags')->insert([
            'name'=>'PHP',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('tags')->insert([
            'name'=>'Vue.js',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('tags')->insert([
            'name'=>'Laravel',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
         DB::table('tags')->insert([
            'name'=>'Node',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
           DB::table('tags')->insert([
            'name'=>'HTML',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
             DB::table('tags')->insert([
            'name'=>'CSS',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
             DB::table('tags')->insert([
            'name'=>'前端',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
                DB::table('tags')->insert([
            'name'=>'后端',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }
}
