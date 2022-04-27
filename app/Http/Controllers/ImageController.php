<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Image; 
use App\Models\Comment; 
use App\Models\Like; 
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

    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename); 
        return new Response($file, 200); 
    }

    public function detail($id) {
        $image = Image::find($id); 

        return view('image.detail', [
            'image' => $image
        ]); 
    }

    public function delete($id) {
        $user = \Auth::user();
        $image = Image::find($id); 
        $comments = Comment::where('image_id', $id)->get(); 
        $likes = Like::where('image_id', $id)->get();

        if($user && $image && $image->user->id == $user->id) {
            //Delete comments
            if($comments && count($comments)  >= 1) {
                foreach($comments as $comment){
                    $comment->delete(); 
                }
            }
            //Delete likes
            if($likes && count($likes)  >= 1) {
                foreach($likes as $like){
                    $like->delete(); 
                }
            }
            //Delete image files
            Storage::disk('images')->delete($image->image_path); 

            //Delete image from DB
            $image->delete(); 
            $message = array('message' => 'Deleted!'); 
        } else {
            $message = array('message' => 'Cannot delete'); 
        }

        return redirect()->route('home')->with($message);
    }

    public function edit($id) {
        $user = \Auth::user();
        $image = Image::find($id); 

        if($user && $image && $image->user->id == $user->id) {
            return view('image.edit', [
                'image' => $image
            ]); 
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request) {
        //Get data
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path'); 
        $description = $request->input('description');

         //Validation
         $validate = $this->validate($request, [
            'description'=> 'required', 
            'image_path'=> 'image'
        ]);

        //Get image object from DB
        $image = Image::find($image_id); 
        $image->description = $description; 

        //Post image    
        if($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName(); 
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;  
        }

        //Refresh register
        $image->update();  

        return redirect()->route('image.detail', ['id' => $image_id])
            ->with(['message' => 'Updated!']);



    }
}
