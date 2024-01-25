<?php

namespace App\Http\Controllers;

use App\Services\CarService;

class CarController extends AbstractController
{
    public function __construct(
        private CarService $service
    )
    {
        parent::__construct($this->service);
    }
}
