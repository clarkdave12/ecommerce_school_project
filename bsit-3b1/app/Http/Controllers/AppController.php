<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use GuzzleHttp\Client;
use DB;
use App\Role;
use App\Order;

class AppController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function validateCaptcha(Request $request)
    {
        $client = new Client();
        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('RECAPTCHA_SECRET'),
                'response' => $request->captchaToken
            ]
        ]);

        return $response->getBody();
    }

    public function register(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
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

    public function manageUsers()
    {
        return DB::table('users')
                    ->join('roles', 'users.id', '=', 'roles.user_id')
                    ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.address')
                    ->where('roles.name', 'User')
                    ->get();
    }

    public function removeUser($id)
    {
        $user = User::find($id);
        $roles = Role::where('user_id', $id)->get();

        foreach($roles as $role)
        {
            $role->delete();
        }

        $user->delete();

        return response()->json(['Success', 'User account removed successfully'], 200);
    }

    public function getOrders()
    {
        return Order::orderBy('created_at', 'desc')->get();
    }

    public function getShippingInfo($id)
    {
        return User::find($id);
    }
}
