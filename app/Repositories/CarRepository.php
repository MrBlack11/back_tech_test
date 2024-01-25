<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class CarRepository extends AbstractRepository
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
