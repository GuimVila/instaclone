<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        return view('image.create');
    }

    public function save(Request $request) {

        //Validation

        $validate = $this->validate($request, [
            'description'=> 'required', 
            'image_path'=> 'required|image'
        ]);

        //Get data
        $image_path = $request->file('image_path'); 
        $description = $request->input('description');

        //Assign values to new object
        $user = \Auth::user(); 
        $image = new Image();
        $image->user_id = $user->id;  
   
        $image->description = $description; 
        
        //Post image

        if($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName(); 
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;  
        }

        $image->save(); 

        return  redirect()->route('home')->with([
            'message' => 'Posted!'
        ]); 
    }
}
