<?php

namespace App\Http\Controllers\v1\Audience;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return response()->json($response);
    }

    /**
     * Store an audience for user.
     */
    public function store(Request $request)
    {
        # TODO implement store audience for user
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
