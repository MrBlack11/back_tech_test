<?php

namespace App\Services;

use App\Repositories\CarRepository;
use Illuminate\Database\Eloquent\Model;

class CarService extends AbstractService
{
    public function __construct(
        private Model $model
    )
    {
        parent::__construct(new CarRepository($this->model));
    }
}
