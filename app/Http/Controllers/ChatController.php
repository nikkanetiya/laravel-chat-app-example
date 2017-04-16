<?php

namespace App\Http\Controllers;

class ChatController extends Controller
{
    /**
     * Get chat view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('chat');
    }
}
