<?php

namespace App\Http\Controllers;

/**
 * Class ChatController
 * @package App\Http\Controllers
 */
class ChatController extends Controller
{
    /**
     * Get chat view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        // Get all other users
        $users = $user->exceptMe($user->id)->get();

        // Add all conversation with each user, for now
        // Need to apply lazy loading later on
        $userWithConversations = $users->each(function ($item, $key) use($user) {
            $item->conversations = [];
        });

        return view('chat', compact('user', 'userWithConversations'));
    }
}
