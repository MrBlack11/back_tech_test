<?php

namespace App\Services;

use App\Repositories\CarRepository;

class CarService extends AbstractService
{
    public function __construct(
        private readonly CarRepository $repository
    )
    {
        parent::__construct($this->repository);
    }
}
