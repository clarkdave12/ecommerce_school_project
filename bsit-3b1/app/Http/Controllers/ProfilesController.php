<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Profile;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $data = DB::table('profiles')
                    ->join('users', 'users.id', '=', 'profiles.user_id')
                    ->select('users.first_name',
                             'users.last_name',
                             'users.email',
                             'users.address',
                             'profiles.age',
                             'profiles.gender',
                             'profiles.work',
                             'profiles.user_id',
                             'profiles.image',
                             'profiles.religion')
                    ->where('profiles.user_id', $id)
                    ->get();

        return response()->json(['profile' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
