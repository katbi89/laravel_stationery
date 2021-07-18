<?php

use Illuminate\Database\Seeder;

class CustomerPaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CustomerPayment::class, 100)->create();
    }
}
