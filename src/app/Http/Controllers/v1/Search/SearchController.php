<?php

namespace App\Http\Controllers\v1\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\SearchRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{

    public function search(SearchRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $data = match ($validatedData['type']) {
            'name' => $this->searchWithName($validatedData['content']),
            'email' => $this->searchWithEmail($validatedData['content']),
            default => $this->searchWithUsername($validatedData['content']),
        };

        return \response()
            ->json($data, Response::HTTP_OK);
    }

    protected function searchWithUsername(string $username)
    {
        $username = '%' . $username . '%';
        return User::where('username', 'LIKE', $username)
            ->paginate();
    }

    protected function searchWithName(string $name)
    {
        $name = '%' . $name . '%';

        return Auth::user()
            ->audiences()
            ->where('firstname', 'LIKE', $name)
            ->orWhere('lastname', 'LIKE', $name)
            ->paginate();
    }

    protected function searchWithEmail(string $email)
    {
        $email = '%' . $email . '%';

        return Auth::user()
            ->where('email', 'LIKE', $email)
            ->paginate();
    }
}
