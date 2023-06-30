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
    public function show(string $id): JsonResponse
    {
        $audience = Auth::user()->audiences()->find($id);

        # TODO checking middleware for existing audience
        $response = $audience ??= [
            'message' => __('مخاطب یافت نشد!'),
        ];

        return \response()
            ->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from audiences of user.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = Auth::user();

        $audience = $user->audiences()->find($id);

        # TODO middleware checking for exists audience for user (replace with if statement) and change this method and return http_no_content when deleted
        if ($audience) {
            $user->audiences()->detach($id);
            $response = [
                'message' => __('مخاطب مورد نظر با موفقیت حذف شد.'),
            ];
        } else {
            $response = [
                'message' => __('مخاطب یافت نشد!'),
            ];
        }

        return \response()
            ->json($response, Response::HTTP_ACCEPTED);
    }
}
