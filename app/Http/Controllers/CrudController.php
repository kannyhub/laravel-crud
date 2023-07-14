<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CrudController extends Controller
{
    public function index(Request $request) {
        if (isset($request->keyword) && $request->keyword != '') {
            $keyword = $request->keyword;
            $users = User::where('role','user')
            ->orderBy('id', 'desc')
            ->where('name','like','%'.$keyword.'%')
            ->orWhere('email','like','%'.$keyword.'%')
            ->paginate(5);
        } else {
            $users = User::where('role','user')
            ->orderBy('id', 'desc')
            ->paginate(5);
        }
        
        return view('user.list',compact('users'));
    }

    public function create(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email'=> 'required|unique:users',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=>Hash::make($request->password)
        ]);
        return response()->json(['status'=>'success']);
    }

    public function edit(Request $request) {
        $user = User::where('id',$request->id)->first();
        return view('user.edit',compact('user'));
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        try {
            $user = User::where('id',$request->id)->first();
            if ($user) {
                $user->name = $request->name;
                $user->update();
            }
            Session::flash('success', 'Data updated successfully'); 
        } catch(\Exception $e) {
            Session::flash('error', 'Something went wrong.Please try again.'); 
        }
        return Redirect::back();
        // return Redirect::to(route('user.edit',$request->id));
    }

    public function delete(Request $request) {
        $user = User::where('id',$request->id)->first();
        if ($user) {
            $user->delete();
            $status = 'success';
        } else {
            $status = 'error';
        }
        return response()->json(['status' => $status]);
    }
}
