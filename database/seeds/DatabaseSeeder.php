<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // Delete users first
        // DB::collection('users')->delete();

        // Insert to database
        $user = DB::collection('users')->insert([
            'name' => 'Jap Ignacio',
            'email' => 'roaldjap@gmail.com',
            'password' => 'testtest'
        ]);

        $post = DB::collection('post')->insert([
            'title' => "Awesome Article", 
            'body' => "Here is some Sample content please see.", 
            'user_id' => $user->id
        ]);

        $post_image = DB::collection('post')->insert([
            'title' => "Awesome Article", 
            'body' => "Here is some Sample content please see.", 
            'user_id' => $user->id
        ]);
    }
}
