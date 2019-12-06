<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Define Models here
use App\Post;
use App\PostImage;

// Define services
use Auth;
use Storage;

class PostController extends Controller
{
    //
    public function getAllPosts(){
        // create a query
        $posts = Post::with('post_images')->orderBy('created_at')->get();
        // respond as json
        return response()->json(['error' => false, 'data'=> $posts]);
    }

    public function createPost(Request $request)
    {
        // Grab the data we need from $request object
        // 1. Authenticated user
        $user = Auth::user();
        // 2. title
        $title = $request->title;
        // 3. content
        $body = $request->body;
        // 4. Array of post images
        $images = $request->images;


        // Create a post
        $post = Post::create([
            'title' => $title,
            'body' => $body,
            'user_id' => $user->id,
        ]);

        foreach($images as $image){
            // put image path in a variable
            $imagePath = Storage::disk('uploads')->put($user->email . 'posts', $image);
            PostImage::create([ 
                'post_image_caption' => $title,
                'post_image_path' => '/uploads/' . $imagePath,
                'post_id' => $post -> id
            ]);
        }

        // respond as json
        return response()->json(['error' => false, 'data' => post]);

    }
}
