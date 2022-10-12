<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as faker;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Faker::create();
        $gender = $faker->randomElement(['male', 'female']);
        foreach (range(1,10) as $index) {
        DB::table('customers')->insert([
            'title' => $faker->randomElement(['Mr', 'Mrs']), 
            'user_id' => '0',
            'fname' => $faker->firstName($gender),
            'lname' => $faker->lastName(),
            'addressline' => $faker->secondaryAddress(),
            'town' => $faker->state(),
            'zipcode' => $faker->buildingNumber(),
            'phone' => $faker->e164PhoneNumber(),
            'creditlimit' => $faker->numberBetween(1000, 10000),
            'level' => $faker->randomElement(['Gold', 'Plat', 'Silver', 'Bronze', 'Diamond'])
        ]);

        DB::table('item')->insert([
            'description' => $faker->word(), 
            'cost_price' => $faker->randomFloat(1, 10, 30),
            'sell_price' => $faker->randomFloat(1, 15, 30),
            'title' => $faker->word(),
            'imagePath' => 'https://media.tenor.com/zI3wh1MhXEAAAAAC/pokemon-hello.gif'
        ]);

        DB::table('artists')->insert([
            'artist_name' => $faker->name() 
        ]);

        }
    }
}
