<?php

use Illuminate\Database\Seeder;

class BillItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\BillItem::class, 500)->create();
    }
}
