<?php

namespace App\Http\Controllers;

use App\Services\AbstractService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class AbstractController extends Controller
{
    public function __construct(
        private AbstractService $service
    )
    {
    }

    public function index()
    {
        return $this->service->list();
    }

    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function show(int $id)
    {
        return $this->service->find($id);
    }

    public function update(Request $request, int $id)
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
}
