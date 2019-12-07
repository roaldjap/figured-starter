<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Post;
use App\PostImage;

class PostImageSeeder extends Seeder {

  public function run()
  {
    echo "Seeding Posts Images...";
    
    DB::collection('post_images')->delete();

    $post = Post::where("title", "There's a reason we call dogs man's best friend")->first();

    PostImage::create([
      'post_image_caption' => "Cute dogs", 
      'post_image_path' => "https://placedog.net/640/480?random", 
      'post_id' => $post->id
    ]);


    echo " Seeded.\n";
  }
}