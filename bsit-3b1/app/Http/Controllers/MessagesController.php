<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use DB;

class MessagesController extends Controller
{
    public function index() {

    }

    public function show($id) {

        $message = Message::orderBy('created_at', 'asc')
                            ->where('sender_id', $id)
                            ->orWhere('receiver_id', $id)
                            ->get();

        return response()->json(['messages' => $message], 200);
    }

    public function store(Request $request) {

        $message = new Message();

        $message->sender_id = $request->sender_id;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();
        
        return response()->json(['message' => 'Message Sent'], 200);
    }

    public function getReply($id, $message) {

        

        return $reply;
    }

    public function saveReply(Request $request) {

        $message = new Message();
        
        $message->sender_id = 1;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;

        $message->save();

        return response()->json(['Success' => 'Message saved'], 200);
    }
}
