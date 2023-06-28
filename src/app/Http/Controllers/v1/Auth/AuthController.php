<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        # TODO middleware checking for check duplicate phone number
        # TODO add middleware for check phone number is validated or not

        # TODO add repository pattern

        # TODO add error handling for eloquent
        $user = User::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'] ?? null,
            'phone' => $validatedData['phone'],
        ]);

        $token = $user->createToken('access_token')->accessToken;

        # TODO add global response for error and success
        $response = [
            'user' => $user,
            'accessToken' => $token,
            'message' => $user->firstname . ' ' . __('عزیز خوش اومدی :)'),
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        # TODO add middleware for checking validation of phone number for login
        $validatedData = $request->validated();

        $user = User::where(['phone' => $validatedData['phone']])->first();

        $token = $user->createToken('access_token')->accessToken;

        # TODO add global response for error and success
        $response = [
            'user' => $user,
            'accessToken' => $token,
            'message' => $user->firstname . __(' عزیز خوش اومدی :)'),
        ];

        return response()->json($response, Response::HTTP_ACCEPTED);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->delete(); // delete current access token and logout

        # TODO add global response for error and success

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
