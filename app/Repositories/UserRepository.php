<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class UserRepository extends AbstractRepository
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
