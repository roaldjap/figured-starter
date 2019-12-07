<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Post;
use App\PostImage;

class PostSeeder extends Seeder {

  public function run()
  {
    echo "Seeding Posts ...";
    DB::collection('posts')->delete();

    $user = User::where('email', 'roaldjap@gmail.com')->first();

    Post::create([
      'title' => "There's a reason we call dogs man's best friend", 
      'body' => "Dogs. There's a reason we call them man's best friend. We can learn so many things from a dog's behavior, personality, demeanor, resiliency, and most importantly, the willingness to provide their family members with unconditional love, loyalty, and companionship down to their very last breath.", 
      'user_id' => $user->_id
    ]);


    echo " Seeded.\n";
  }
}