<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationApiException;
use App\Services\AbstractService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

abstract class AbstractController extends Controller
{
    public function __construct(
        private readonly AbstractService $service,
    )
    {
    }

    public function index(): Collection
    {
        return $this->service->list();
    }

    public function store(FormRequest $request): Model
    {
        $this->validateErrors($request);

        return $this->service->create($request->all());
    }

    public function show(int $id): Model
    {
        return $this->service->find($id);
    }

    public function update(FormRequest $request, int $id): Model
    {
        $this->validateErrors($request, true);

        return $this->service->update($request->all(), $id);
    }

    public function destroy(int $id): Response|JsonResponse
    {
        $this->service->delete($id);

        return response()->noContent();
    }

    private function validateErrors(Request $request, bool $isUpdating = false): array
    {
        $formValidator = $this->getFormValidator($isUpdating);

        $rules = $formValidator->rules();
        $validator = Validator::make($request->input(), $rules, $formValidator->messages());

        if ($validator->fails()) {
            throw new ValidationApiException($validator->errors());
        }

        return $validator->validate();
    }

    abstract public function getFormValidator(bool $isUpdating): FormRequest;
}
