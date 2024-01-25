<?php

namespace App\Repositories;

use App\Models\UserCar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserRepository extends AbstractRepository
{
    public function __construct(
       private readonly Model $model
    )
    {
        parent::__construct($this->model);
    }

    public function listCars(int $id): Collection | null
    {
        $obj = $this->model::find($id);

        return $obj?->cars;
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
