<?php

namespace App\Http\Controllers\API;

use App\Conversation;
use App\Events\ConversationEvent;
use App\Http\Requests\ConversationRequest;

/**
 * Class ConversationController
 * @package App\Http\Controllers\API
 */
class ConversationController extends BaseAPIController
{
    /**
     * Store Conversation
     */
    public function store(ConversationRequest $request)
    {
        $data = $request->all();

        $data['sender_id'] = auth()->id();

        if($conversation = Conversation::create($data)) {

            event(new ConversationEvent($conversation));
            return $this->responseSuccess();
        }

        return $this->responseError();
    }

    /**
     * Get conversation with user
     *
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    function getConversations($userId)
    {
        $user = auth()->user();

        return $this->responseSuccess([
            'conversations' => $user->conversationWithUser($userId)->get()
        ]);
    }
}
