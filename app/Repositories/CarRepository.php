<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class CarRepository extends AbstractRepository
{
    public function __construct(
        private readonly Model $model
    )
    {
        parent::__construct($this->model);
    }
}
