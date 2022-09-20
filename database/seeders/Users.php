<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Facker;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Facker::create();



        for ($i = 0 ; $i<10 ; $i++){

            $array =[
                'name' => $faker->word,
                'email'=> $faker->email,
                'password'=>Hash::make(123456789),
                'is_admin'=>$faker->boolean(),
            ];
            \App\Models\User::create($array);
        }
    }
}
