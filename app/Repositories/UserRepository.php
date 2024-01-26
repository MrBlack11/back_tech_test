<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Models\Car;
use App\Models\UserCar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\UniqueConstraintViolationException;

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
                fn($join) => $join->on("user_cars.car_id", "=", 'cars.id')->where('user_cars.user_id', '=', $id)
            )
            ->paginate();
    }

    public function addCar(int $id, int $carId): UserCar
    {
        try {
            return UserCar::create([
                'car_id' => $carId,
                'user_id' => $id
            ]);
        } catch (UniqueConstraintViolationException $exception) {
            throw new \InvalidArgumentException("The relation already exists.", 400);
        }
    }

    public function removeCar(int $id, int $carId): bool
    {
        $userCar = UserCar::where(['car_id' => $carId,'user_id' => $id])->first();
        if (is_null($userCar)) {
            throw new NotFoundException("Relation doesn't exists.");
        }

        return $userCar->delete();
    }
}
