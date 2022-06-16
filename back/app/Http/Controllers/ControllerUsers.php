<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;

class ControllerUsers extends Controller
{
    function all()
    {
        return User::all();
    }

    function add(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();
        return $user;
    }

    function del($id)
    {
       $user = User::find($id);
       $user->delete();
    }
}
