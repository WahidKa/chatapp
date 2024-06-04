<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
{
    $chatRooms = Auth::user()->chatRooms()
        ->with(['messages' => function($query) {
            $query->latest();
        }, 'participants'])
        ->get()
        ->sortByDesc(function($chatRoom) {
            return $chatRoom->messages->first() ? $chatRoom->messages->first()->created_at : $chatRoom->created_at;
        });

    return view('chat.index', compact('chatRooms'));
}

    // ChatController.php
    public function show($roomID)
    {
        $chatRoom = ChatRoom::findOrFail($roomID);
        $messages = $chatRoom->messages()->with('user')->get();
        return view('chat.show', compact('chatRoom', 'messages'));
    }


    public function createChatRoom()
    {
        return view('chat.create');
    }

    public function storeChatRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $chatRoom = new ChatRoom;
        $chatRoom->name = $request->name;
        $chatRoom->save();

        // Add the creator as a participant
        $chatRoom->participants()->attach(Auth::id());

        return redirect()->route('chat.index');
    }

    public function sendMessage(Request $request, $roomID)
    {
        $request->validate([
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,txt'
        ]);

        $message = new Message;
        $message->content = $request->content;
        $message->roomID = $roomID;
        $message->userID = Auth::id();

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public'); // Ensure it's stored in the 'public' disk
            $message->file_path = $filePath;
        }

        $message->save();

        return redirect()->route('chat.show', $roomID);
    }
    public function addParticipantsForm($roomID)
    {
        $chatRoom = ChatRoom::findOrFail($roomID);
        $existingParticipants = $chatRoom->participants()->pluck('userID')->toArray();
        $users = User::where('id', '!=', Auth::id())->whereNotIn('id', $existingParticipants)->get(); // Exclude the logged-in user and existing participants
        return view('chat.add-participants', compact('chatRoom', 'users'));
    }

    public function addParticipants(Request $request, $roomID)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        $chatRoom = ChatRoom::findOrFail($roomID);
        $chatRoom->participants()->syncWithoutDetaching($request->users);

        return redirect()->route('chat.show', $roomID);
    }
}
