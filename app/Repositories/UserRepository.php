<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\UserCar;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends AbstractRepository
{
    public function __construct(
       private readonly Model $model
    )
    {
        parent::__construct($this->model);
    }

    public function listCars(int $id)
    {
        return Car::selectRaw("cars.*")
            ->join(
                "user_cars",
                fn ($join) => $join->on("user_cars.car_id", "=", 'cars.id')->where('user_cars.user_id', '=', $id)
            )
            ->paginate();
    }

    public function addCar(int $id, int $carId): UserCar
    {
        return UserCar::create([
            'car_id' => $carId,
            'user_id' => $id
        ]);
    }

    public function removeCar(int $id, int $carId): bool
    {
        return UserCar::where([
            'car_id' => $carId,
            'user_id' => $id
        ])->delete();
    }
}
