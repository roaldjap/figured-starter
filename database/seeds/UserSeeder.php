<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Post;
use App\PostImage;

class UserSeeder extends Seeder {

  public function run()
  {
    echo "Seeding Users ...";
    DB::collection('users')->delete();

    User::create([
      'name' => 'Jap Ignacio',
      'email' => 'roaldjap@gmail.com',
      'password' => Hash::make('testtest') 
    ]);


    echo " Seeded.\n";
  }
}