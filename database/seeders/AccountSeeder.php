<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use Faker\Factory as Faker;

class AccountSeeder extends Seeder
{
  public function run()
  {
    $faker = Faker::create();

    foreach (range(1, 25) as $index) {
      Account::create([
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'status' => $faker->randomElement(['active', 'inactive']),
      ]);
    }
  }
}
