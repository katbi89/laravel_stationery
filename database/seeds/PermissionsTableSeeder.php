<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Item Permissions
        Permission::firstOrCreate(['name' => 'item view']);
        Permission::firstOrCreate(['name' => 'item create']);
        Permission::firstOrCreate(['name' => 'item update']);
        Permission::firstOrCreate(['name' => 'item delete']);
        Permission::firstOrCreate(['name' => 'item restore']);
        Permission::firstOrCreate(['name' => 'item forceDelete']);

        // Supplier Permissions
        Permission::firstOrCreate(['name' => 'supplier view']);
        Permission::firstOrCreate(['name' => 'supplier create']);
        Permission::firstOrCreate(['name' => 'supplier update']);
        Permission::firstOrCreate(['name' => 'supplier delete']);
        Permission::firstOrCreate(['name' => 'supplier restore']);
        Permission::firstOrCreate(['name' => 'supplier forceDelete']);

        // Bill Permissions
        Permission::firstOrCreate(['name' => 'bill view']);
        Permission::firstOrCreate(['name' => 'bill create']);
        Permission::firstOrCreate(['name' => 'bill update']);
        Permission::firstOrCreate(['name' => 'bill delete']);
        Permission::firstOrCreate(['name' => 'bill restore']);
        Permission::firstOrCreate(['name' => 'bill forceDelete']);

        // Supplier Payment Permissions
        Permission::firstOrCreate(['name' => 'supplierPayment view']);
        Permission::firstOrCreate(['name' => 'supplierPayment create']);
        Permission::firstOrCreate(['name' => 'supplierPayment update']);
        Permission::firstOrCreate(['name' => 'supplierPayment delete']);
        Permission::firstOrCreate(['name' => 'supplierPayment restore']);
        Permission::firstOrCreate(['name' => 'supplierPayment forceDelete']);

        // Customer Permissions
        Permission::firstOrCreate(['name' => 'customer view']);
        Permission::firstOrCreate(['name' => 'customer create']);
        Permission::firstOrCreate(['name' => 'customer update']);
        Permission::firstOrCreate(['name' => 'customer delete']);
        Permission::firstOrCreate(['name' => 'customer restore']);
        Permission::firstOrCreate(['name' => 'customer forceDelete']);

        // Order Permissions
        Permission::firstOrCreate(['name' => 'order view']);
        Permission::firstOrCreate(['name' => 'order create']);
        Permission::firstOrCreate(['name' => 'order update']);
        Permission::firstOrCreate(['name' => 'order delete']);
        Permission::firstOrCreate(['name' => 'order restore']);
        Permission::firstOrCreate(['name' => 'order forceDelete']);

        // CustomerPayment Permissions
        Permission::firstOrCreate(['name' => 'customerPayment view']);
        Permission::firstOrCreate(['name' => 'customerPayment create']);
        Permission::firstOrCreate(['name' => 'customerPayment update']);
        Permission::firstOrCreate(['name' => 'customerPayment delete']);
        Permission::firstOrCreate(['name' => 'customerPayment restore']);
        Permission::firstOrCreate(['name' => 'customerPayment forceDelete']);
    }
}
