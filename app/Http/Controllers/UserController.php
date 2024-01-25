<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $service
    )
    {
        parent::__construct($this->service);
    }
}
