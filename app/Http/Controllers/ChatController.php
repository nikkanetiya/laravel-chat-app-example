<?php

namespace App\Http\Controllers;

use App\User;

class ChatController extends Controller
{
    /**
     * Get chat view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Select Random current user till when don't have login
        $user = User::select('id', 'name', 'image')->inRandomOrder()->first();

        // Get all other users
        $users = $user->exceptMe($user->id)->get();

        // Add all conversation with each user, for now
        // Need to apply lazy loading later on
        $userWithConversations = $users->each(function ($item, $key) use($user) {
            $item->conversations = $user->conversationWithUser($item->id)->get()->toArray();
        });

        return view('chat', compact('user', 'userWithConversations'));
    }
}
