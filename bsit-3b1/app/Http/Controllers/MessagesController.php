<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use DB;
use App\Events\MessageSent;
use App\User;
use App\Role;

class MessagesController extends Controller
{
    public function index() 
    {
        $m = 'asdasd';

        event(new TestEvent($m));
    }

    public function show($id)
    {
        return Message::where('sender', $id)->orWhere('receiver', $id)->get();
    }

    public function store(Request $request)
    {
        $m = new Message();
        $m->message = $request->message;
        $m->sender = $request->sender;
        $m->receiver = $request->receiver;
        $m->save();

        event(new MessageSent());
    }

    public function messageAdmin()
    {
        $admins = DB::table('users')
                    ->join('roles', 'users.id', '=', 'roles.user_id')
                    ->select('users.id', 'users.first_name', 'users.last_name')
                    ->where('roles.name', 'Admin')
                    ->get();

        return $admins;
    }

    public function messageUser()
    {
        $users = DB::table('users')
                    ->join('roles', 'users.id', '=', 'roles.user_id')
                    ->select('users.id', 'users.first_name', 'users.last_name')
                    ->where('roles.name', 'User')
                    ->get();

        return $users;
    }
}
