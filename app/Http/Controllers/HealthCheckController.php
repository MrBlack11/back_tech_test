<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

class HealthCheckController extends Controller
{
    public function __invoke()
    {
        return response()->json(Response::HTTP_OK);
    }
}
