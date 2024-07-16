<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DashboardItem;

class DashboardItemsSeeder extends Seeder
{
  public function run()
  {
    $categories = ['Electronics', 'Clothing', 'Books', 'Food', 'Toys'];

    for ($i = 1; $i <= 50; $i++) {
      DashboardItem::create([
        'title' => "Item $i",
        'price' => rand(10, 1000) / 10,
        'description' => "This is the description for item $i",
        'category' => $categories[array_rand($categories)],
      ]);
    }
  }
}
