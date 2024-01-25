<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class UserService extends AbstractService
{
    public function __construct(
        private Model $model
    )
    {
        parent::__construct(new UserRepository($this->model));
    }
}
