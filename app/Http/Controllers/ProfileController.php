<?php

namespace App\Http\Controllers;
use App\Mail\ProfileUpdated;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function getProfileView() {
        //this line utk initialize authentication selected user to view ONLY their own data
        $user = Auth::user();

        return view('profile.view', compact('user'));

    }

    public function postProfile() 
    {
            $validatedData= request()->validate([
                'name' => 'required',
                'email' => 'required|email',
                'photo' => 'image',
                'password' => 'confirmed',

            ]);


        //this line utk initialize authentication selected user to view ONLY their own data
        $user = Auth::user();

        $user->name = request()->name;
        $user->email = request()->email;
        //hashing the pssword after edit it
        $user->password =\Hash::make(request()->password);


        // dd(request()->all(),request()->filled('photo'));

        if(request()->has('photo'))
        {
            $path=explode('/', request()->file('photo')->store('public/profile_directory'));
            // dd($path);
            unset($path[0]);
            $publicPath="storage/" . implode('/',$path);
            $user->photo_path= $publicPath;
        }

        $user->save();
        Mail::to($user)->send(new ProfileUpdated());
        return redirect()->back()->with('status', 'Succesfully saved');
    }

}
