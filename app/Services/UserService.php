<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Collection;

class UserService extends AbstractService
{
    public function __construct(
        private readonly UserRepository $repository,
    )
    {
        parent::__construct($this->repository);
    }

    public function listCars(int $id) : Collection|null
    {
        return $this->repository->listCars($id);
    }

    public function addCar(int $id, int $carId)
    {
        return $this->repository->addCar($id, $carId);
    }

    public function removeCar(int $id, int $carId)
    {
        return $this->repository->removeCar($id, $carId);
    }
}
