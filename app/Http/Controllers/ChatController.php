<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display the chat interface.
     */
    public function index(User $receiver = null)
    {
        $userId = Auth::id();

        // Get all users the current user has chatted with
        $conversations = User::whereIn('id', function($query) use ($userId) {
            $query->select('sender_id')
                ->from('messages')
                ->where('receiver_id', $userId)
                ->union(
                    DB::table('messages')
                        ->select('receiver_id')
                        ->from('messages')
                        ->where('sender_id', $userId)
                );
        })
        ->withCount(['messages as unread_count' => function($query) use ($userId) {
            $query->where('receiver_id', $userId)
                  ->where('is_read', false);
        }])
        ->withMax('messages', 'created_at')
        ->orderByDesc('messages_max_created_at')
        ->get();

        $messages = collect();
        if ($receiver) {
            // Mark as read
            Message::where('sender_id', $receiver->id)
                ->where('receiver_id', $userId)
                ->update(['is_read' => true]);

            $messages = Message::where(function($q) use ($userId, $receiver) {
                $q->where('sender_id', $userId)->where('receiver_id', $receiver->id);
            })->orWhere(function($q) use ($userId, $receiver) {
                $q->where('sender_id', $receiver->id)->where('receiver_id', $userId);
            })->orderBy('created_at', 'asc')->get();
        }

        return view('chat.index', compact('conversations', 'receiver', 'messages'));
    }

    /**
     * Send a new message.
     */
    public function sendMessage(Request $request, User $receiver)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver->id,
            'body' => $request->body,
            'is_read' => false,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'html' => view('chat.partials.message', ['message' => $message])->render()
            ]);
        }

        return back();
    }

    /**
     * Get new messages (Polling endpoint).
     */
    public function getUpdates(User $receiver)
    {
        $userId = Auth::id();
        
        $newMessages = Message::where('sender_id', $receiver->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read immediately
        Message::whereIn('id', $newMessages->pluck('id'))
            ->update(['is_read' => true]);

        $html = '';
        foreach ($newMessages as $msg) {
            $html .= view('chat.partials.message', ['message' => $msg])->render();
        }

        return response()->json([
            'count' => $newMessages->count(),
            'html' => $html
        ]);
    }

    /**
     * Get unread messages count for the navbar.
     */
    public function getUnreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
