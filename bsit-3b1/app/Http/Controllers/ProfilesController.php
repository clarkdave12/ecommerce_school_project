<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Profile;
use App\User;
use DB;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        /* Decode the image String */
        $exploded = explode(',', $request->image);
        $decoded = base64_decode($exploded[1]);

        /* Get the extension */
        if(Str::contains($exploded[0], 'jpeg')) {
            $extension = 'jpg';
        }
        else {
            $extension = 'png';
        }

        /* Generate Filename */
        $filename = Str::random(30) . '.' . $extension;

        /* Saving to public path */
        $path = public_path() . '/' . $filename;
        file_put_contents($filename, $decoded);

        /* Save data to database */
        return Profile::create([
            'age' => $request->age,
            'gender' => $request->gender,
            'work' => $request->work,
            'religion' => $request->religion,
            'user_id' => $request->user_id,
            'image' => $filename
        ]);

    }

    public function updateProfile(Request $request, $user_id) {
        $profile = User::find($user_id);

        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->address = $request->address;
        $profile->email = $request->email;
        $profile->save();

        return response()->json(['message' => 'User profile updated successfully'], 200);
    }

    public function show($id)
    {
         $data = DB::table('profiles')
                    ->rightjoin('users', 'users.id', '=', 'profiles.user_id')
                    ->select('users.first_name',
                             'users.last_name',
                             'users.email',
                             'users.address',)
                    ->where('users.id', $id)
                    ->get();

        return response()->json(['profile' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        return User::find($id);
    }
}
