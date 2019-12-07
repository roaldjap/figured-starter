<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        Eloquent::unguard();

        // For fresh database seed.
        $this->call('UserSeeder');
        $this->call('PostSeeder');
        $this->call('PostImageSeeder');
       
    }
}
