<?php

use App\Inventory;
use Illuminate\Database\Seeder;


class InventoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inventory = factory(Inventory::class, 10)->create();
    }
}
