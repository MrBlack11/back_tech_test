<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationApiException;
use App\Services\AbstractService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class AbstractController extends Controller
{
    public function __construct(
        private readonly AbstractService $service,
    )
    {
    }

    public function index()
    {
        return $this->service->list();
    }

    public function store(FormRequest $request)
    {
        $this->validateErrors($request);

        return $this->service->create($request->all());
    }

    public function show(int $id)
    {
        return $this->service->find($id);
    }

    public function update(FormRequest $request, int $id)
    {
        try {
            return $this->service->update($request->all(), $id);
        } catch (\DomainException $exception) {
            return $this->respondWithError($exception->getMessage(), 404);
        }
    }

    public function destroy(int $id)
    {
        $wasRemoved = $this->service->delete($id);

        return $wasRemoved ?
            response()->noContent() :
            $this->respondWithError("Couln't remove object");
    }

    protected function respondWithError(string $message, int $statusCode = 500): JsonResponse
    {
        return response()->json([
            "error" => true,
            "message" => $message
        ], $statusCode);
    }

    public function validateErrors(Request $request): array
    {
        $formValidator = $this->getFormValidator();

        $rules = $formValidator->rules();
        $validator = Validator::make($request->input(), $rules, $formValidator->messages());

        if ($validator->fails()) {
            throw new ValidationApiException($validator->errors());
        }

        return $validator->validate();
    }

    abstract public function getFormValidator(): FormRequest;
}
