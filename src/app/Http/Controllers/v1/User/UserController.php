<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
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

    public function update(UpdateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $user = $request->user();

        $user->update([
            'username' => $validatedData['username'] ?? $user->username,
            'firstname' => $validatedData['firstname'] ?? $user->firstname,
            'lastname' => $validatedData['lastname'] ?? $user->lastname,
            'email' => $validatedData['email'] ?? $user->email,
            'bio' => $validatedData['bio'] ?? $user->bio
        ]);

        $response = [
            'message' => __('اطلاعات با موفقیت بروزرسانی شدند')
        ];

        return \response()
            ->json($response, Response::HTTP_ACCEPTED);
    }
}
