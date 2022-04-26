<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function like($image_id) {
        //Get user and image's data
        $user = \Auth::user(); 

        //Check if like exists
        $isset_like = Like::where('user_id', $user->id)
            ->where('image_id', $image_id)
            ->count(); 

        if($isset_like == 0) {
            $like = new  Like(); 
            $like->user_id = $user_id;  
            $like->image_id = (int)$image_id; 

            //Save
            $like->save(); 

            return response()->json([
                'like' => $like
            ]);
        } else {
            return response()->json([
                'message' => 'You already liked this image'
            ]);
        }

    
    }

    public function dislike($image_id) {
            //Get user and image's data
            $user = \Auth::user(); 

            //Check if like exists
            $like = Like::where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->first(); 
    
            if($like) {
                //Delete like
                $like->delete(); 
    
                return response()->json([
                    'like' => $like,
                    'message' => 'You don\'t like this post anymore'
                ]);
            } else {
                return response()->json([
                    'message' => 'There\'s no like to dislike'
                ]);
            }
    }
}
