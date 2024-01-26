<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
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

    public function getFormValidator(bool $isUpdating): FormRequest
    {
        return $isUpdating ? new UpdateCarRequest() : new StoreCarRequest();
    }
}
