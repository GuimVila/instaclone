<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Comment; 

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function store(Request $request) {

        //Validation
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);

        //Get data
        $user = \Auth::user();  
        $image_id = $request->input('image_id');  
        $content = $request->input('content'); 

        //Asign values to new object
        $comment = new Comment(); 
        $comment->user_id = $user->id;  
        $comment->image_id = $image_id; 
        $comment->content = $content; 

        //Save to DB
        $comment->save(); 

        return redirect()->route('image.detail', ['id' => $image_id])
            ->with([
                'message' => 'Posted!' 
            ]);
    }

    public function delete($id) {
        //Get logged user's data
        $user = \Auth::user(); 

        //Get comment object
        $comment = Comment::find($id); 

        //Check if the user is the comment's owner
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user_id)) {
            $comment->delete(); 

            return redirect()->route('image.detail', ['id' => $comment->image->id])
            ->with([
                'message' => 'Comment deleted successfully!' 
            ]);
        } else {
            return redirect()->route('image.detail', ['id' => $comment->image->id])
            ->with([
                'message' => 'Cannot delete this comment' 
            ]);
        } 

    }
}
