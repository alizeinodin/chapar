<?php

namespace App\Http\Controllers\v1\Audience;

use App\Http\Controllers\Controller;
use App\Http\Requests\Audience\StoreAudienceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AudienceController extends Controller
{
    /**
     * Display a listing of the audiences.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $response = [
            'user' => $user,
            'audiences' => $user->audiences,
        ];

        return response()
            ->json($response, Response::HTTP_OK);
    }

    /**
     * Store an audience for user.
     */
    public function store(StoreAudienceRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $request->user()->audiences()->attach($validatedData['id']);

        $response = [
            'message' => __('مخاطب به لیست مخاطبین اضافه شد.'),
        ];

        return response()
            ->json($response, Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified audience of user.
     */
    public function show(string $id)
    {
        # TODO implement show audience of a user
    }

    /**
     * Remove the specified resource from audiences of user.
     */
    public function destroy(string $id)
    {
        # TODO implement delete a audience from list of audiences of user
    }
}
