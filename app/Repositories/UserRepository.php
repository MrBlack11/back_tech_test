<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class UserRepository extends AbstractRepository
{
    public function __construct(
       private readonly Model $model
    )
    {
        parent::__construct($this->model);
    }
}
