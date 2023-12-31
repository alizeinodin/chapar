<?php

namespace App\Http\Controllers\v1\Message;

use App\Events\MessageSendEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages
     */
    public function index(): JsonResponse
    {
        $response = Message::where(['is_delete' => false])->paginate();

        return response()
            ->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created message in chat.
     */
    public function store(StoreMessageRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $chat = $request->user()
            ->chats()
            ->find($validatedData['chat_id']);

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $validatedData['receiver_id'],
            'private_chat_id' => $chat->id,
            'content' => json_encode($validatedData['content'])
        ]);

        event(new MessageSendEvent($message));

        return response()
            ->json($message, Response::HTTP_CREATED);
    }

    /**
     * Display the specified message.
     */
    public function show(Message $message): JsonResponse
    {
        # TODO add permission for show messages of own chat
        $response = $message->is_delete ? [
            'message' => 'پیام مورد نظر یافت نشد'
        ] : $message;
        return response()
            ->json($response, $message->is_delete ? Response::HTTP_NOT_FOUND : Response::HTTP_OK);
    }

    /**
     * Update the specified message in chat.
     */
    public function update(UpdateMessageRequest $request, Message $message): JsonResponse
    {
        $validatedData = $request->validated();

        $message->content = $validatedData['content'];
        $message->save();

        return response()
            ->json($message, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified message from chat.
     */
    public function destroy(Message $message): JsonResponse
    {
        $message->is_delete = !$message->is_delete;
        $message->save();

        return response()
            ->json([], Response::HTTP_NO_CONTENT);
    }
}
