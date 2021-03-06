<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //开发模式 输出sql语句
        if (env('APP_DEBUG')) {
            \DB::listen(function ($query) {
                $tmp = str_replace('?', '"'.'%s'.'"', $query->sql);
                $qBindings = [];
                foreach ($query->bindings as $key => $value) {
                    if (is_numeric($key)) {
                        $qBindings[] = $value;
                    } else {
                        $tmp = str_replace(':'.$key, "'{$value}'", $tmp);
                    }
                }
                $tmp = vsprintf($tmp, $qBindings);
                $tmp = str_replace('\\', '', $tmp);
                \Log::info('execution time: '.$query->time.'ms;  '.$tmp.";\t");
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
