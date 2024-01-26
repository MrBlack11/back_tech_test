<?php

namespace App\Http\Controllers;

use App\Services\CarService;
use Illuminate\Foundation\Http\FormRequest;

class CarController extends AbstractController
{
    public function __construct(
        private CarService $service
    )
    {
        parent::__construct($this->service);
    }

    public function getFormValidator(): FormRequest
    {
        return new FormRequest();
    }
}
