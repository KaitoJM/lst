<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function index() {
        $users = User::all();

        return view('admin.user.index', compact('users'));
    }

    public function edit($user_id) {
        $user = User::find($user_id);

        return view('admin.user.edit', compact('user'));
    }

    public function updateUser(Request $request, $id) {
        $file = $request->file('photo');
        $user = User::find($id);

        if ($file) {
            $destinationPath = 'uploads/users';
            $file->move($destinationPath,$file->getClientOriginalName());

            $user->photo = $file->getClientOriginalName();
        } else {
            return 'no file';
        }

        $user->fname = $request->input('fname');
        $user->lname = $request->input('lname');
        $user->type = $request->input('type');

        $user->save();
        
        return redirect()->route('admin.user');
    }
}
