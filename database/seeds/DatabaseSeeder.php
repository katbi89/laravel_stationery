<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolePermissionsTableSeeder::class);
//
//        $this->call(TreesTableSeeder::class);
//        $this->call(ItemsTableSeeder::class);
//        $this->call(UnitsTableSeeder::class);
//
//        $this->call(SuppliersTableSeeder::class);
//        $this->call(BillsTableSeeder::class);
//        $this->call(BillItemsTableSeeder::class);
//        $this->call(SupplierPaymentsTableSeeder::class);
//
//        $this->call(CustomersTableSeeder::class);
//        $this->call(OrdersTableSeeder::class);
//        $this->call(OrderItemsTableSeeder::class);
//        $this->call(CustomerPaymentsTableSeeder::class);

    }
}
