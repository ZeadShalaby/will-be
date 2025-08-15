<?php

namespace App\Providers;

use App\Models\Kids;
use App\Models\User;
use App\Models\Tests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        //? make all models unguarded
        Model::unguard();

        //?s use in media morph
        Relation::enforceMorphMap([
            'user'  => User::class,
            'kids'  => Kids::class,
            'tests' => Tests::class,
        ]);
        
    }
}
