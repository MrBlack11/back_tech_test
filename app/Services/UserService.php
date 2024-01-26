<?php

namespace App\Services;

use App\Models\UserCar;
use App\Repositories\UserRepository;

class UserService extends AbstractService
{
    public function __construct(
        private readonly UserRepository $repository,
    )
    {
        parent::__construct($this->repository);
    }

    public function listCars(array $request, int $id)
    {
        return $this->repository->listCars($request, $id);
    }

    public function addCar(int $id, int $carId): UserCar
    {
        return $this->repository->addCar($id, $carId);
    }

    public function removeCar(int $id, int $carId)
    {
        return $this->repository->removeCar($id, $carId);
    }
}
