<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $service
    )
    {
        parent::__construct($this->service);
    }

    public function listCars(int $id)
    {
        $cars = $this->service->listCars($id);

        return response()->json($cars);
    }

    public function addCar(Request $request, int $id)
    {
        $this->service->addCar($id, $request->car_id);
    }

    public function removeCar(int $id, int $carId)
    {
        $this->service->removeCar($id, $carId);

        return response()->noContent();
    }

    public function getFormValidator(bool $isUpdating = false): FormRequest
    {
        return $isUpdating ? new UpdateUserRequest() : new StoreUserRequest();
    }
}
