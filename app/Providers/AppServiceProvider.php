<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\User;
use App\Repositories\CarRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->when(CarRepository::class)
            ->needs(Model::class)
            ->give(function() {
                return new Car();
            });

        $this->app->when(UserRepository::class)
            ->needs(Model::class)
            ->give(function () {
                return new User();
            });
    }
}
