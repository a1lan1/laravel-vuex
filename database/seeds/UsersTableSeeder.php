<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.io',
            'password' => bcrypt('admin'),
        ]);

        $admin->assignRole('admin');

        factory(App\User::class, 50)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
