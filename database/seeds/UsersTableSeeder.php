<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Bilal Katbi',
            'email' => 'katbi89@gmail.com',
            'password' => bcrypt('12345678'),
            'role_id' => 1,
        ]);

        $user = User::create([
            'name' => 'Bilal Katbi',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2,
        ]);
    }
}
