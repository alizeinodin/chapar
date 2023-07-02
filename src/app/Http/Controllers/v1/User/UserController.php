<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function getUser(): JsonResponse
    {
        return response()
            ->json(Auth::user(), Response::HTTP_OK);
    }
}
