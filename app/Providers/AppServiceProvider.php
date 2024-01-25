<?php

namespace App\Providers;

use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Models\Car;
use App\Models\User;
use App\Services\CarService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->when(UserController::class)
            ->needs(UserService::class)
            ->give(function () {
                return new UserService(new User());
            });

        $this->app->when(CarController::class)
            ->needs(CarService::class)
            ->give(function() {
                return new CarService(new Car());
            });
    }
}
