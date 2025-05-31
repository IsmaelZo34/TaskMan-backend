<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(app()->environment('production')){
            try{
                Artisan::call('migrate', ['--force' => 'true']);
            }catch (\Exception $e) {
                logger()->error('Migration failed: '.$e->getMessage());
            }
        }
    }
}
