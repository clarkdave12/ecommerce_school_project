<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AppController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function register(Request $request) {

        $this->validate($request, [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->role()->create([
            'name' => 'User'
        ]);

        $user->save();

        return 'success';
    }

    public function getUserRole($id) {
        $user = User::find($id);

        return $user->role->name;
    }

    public function getUserList() {
        $user = User::orderBy('created_at', 'desc')->get();

        return response()->json(['users' => $user], 200); 
    }
}
