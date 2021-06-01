<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user 01',
            'email' => 'asmae.98trb@gmail.com',
            'password' =>'$2y$10$Vkbct9R/R5uwmkOJCaUFpO/TmMHXsdRwP0ttdwPoqBkSASN4Uvvlu' ,
            'role' => 'leader',
            'ref_user' => 12,
            'entity_id' => 1
           
        ]);
     }
}
