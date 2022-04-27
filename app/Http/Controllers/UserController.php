<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User; 


class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($search = null) {
        if(!empty($search)) {
            $users = User::where('nick', 'LIKE', '%'.$search.'%')
                ->orWhere('name', 'LIKE', '%'.$search.'%')
                ->orWhere('surname', 'LIKE', '%'.$search.'%')
                ->orderBy('id', 'desc')
                ->paginate(5);
        } else {
            $users = User::orderBy('id', 'desc')->paginate(5);
        }
        
        return view('user.index', [
            'users' => $users
        ]);
    }

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
        
        //Update img

        $image_path = $request->file('image_path'); 
        if($image_path) {

            // Add unique name
            $image_path_name = time().$image_path->getClientOriginalName(); 

            //Save inn the storage/users folder
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            // Set name into the object
            $user->image = $image_path_name; 
        }
        
        //Make query to DB
        $user->update();

        return redirect()->route('settings')
            ->with(['message'=>'User updated successfully']);
    }
    
    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200); 
    }

    public function profile($id) {
        $user = User::find($id); 

        return view('user.profile', [
            'user' => $user
        ]); 
    }
}
