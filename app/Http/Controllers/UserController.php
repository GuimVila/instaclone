<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    public function config() {
        return view('user.config'); 
    }

    public function update(Request $request) {
        //Get the logged in user
        $user = \Auth::user(); 
        $id = $user->id; 

        //Form validation
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id]
        ]); 

        //Collecting data from form
        $name = $request->input('name'); 
        $surname = $request->input('surname'); 
        $nick = $request->input('nick'); 
        $email = $request->input('email'); 

        //Assign new values to user object
        $user->name = $name; 
        $user->surname = $surname; 
        $user->nick = $nick; 
        $user->email = $email;     
        
        //Make query to DB
        $user->update();

        return redirect()->route('settings')
            ->with(['message'=>'User updated successfully']);
    }
}
