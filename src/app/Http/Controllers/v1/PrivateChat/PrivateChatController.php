<?php

namespace App\Http\Controllers\v1\PrivateChat;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrivateChat\StoreChatRequest;
use App\Models\PrivateChat;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PrivateChatController extends Controller
{
    public function index(): JsonResponse
    {
        $response = Auth::user()
            ->chats()
            ->paginate();

        return response()
            ->json($response, Response::HTTP_OK);
    }

    public function store(StoreChatRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        # TODO add repository pattern for store in db
        $chat = PrivateChat::create([
            'chat_id' => $this->chatId($request->user()->id, $validatedData['user']),
        ]);

        $request->user()
            ->chats()
            ->attach($chat);

        $response = [
            'chat' => $chat,
            'message' => __('چت خصوصی با موفقیت ایجاد شد.')
        ];

        return \response()
            ->json($response, Response::HTTP_CREATED);
    }

    public function show(PrivateChat $chat): JsonResponse
    {
        # TODO add permission for get chat of own user
        return \response()
            ->json($chat, Response::HTTP_ACCEPTED);
    }

    public function destroy(PrivateChat $chat): JsonResponse
    {
        $chat->delete();

        return \response()
            ->json([], Response::HTTP_NO_CONTENT);
    }

    private function chatId(int $firstId, int $secondId): string
    {
        return min($firstId, $secondId) . '_' . max($firstId, $secondId);
    }
}
