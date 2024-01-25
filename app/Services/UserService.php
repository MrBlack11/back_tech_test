<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends AbstractService
{
    public function __construct(
        private readonly UserRepository $repository,
    )
    {
        parent::__construct($this->repository);
    }
}
