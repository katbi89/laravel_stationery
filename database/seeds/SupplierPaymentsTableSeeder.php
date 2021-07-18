<?php

use Illuminate\Database\Seeder;

class SupplierPaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SupplierPayment::class, 100)->create();
    }
}
