<?php

namespace Database\Seeders;


use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::query()->create([
            'name' => 'admin user',
            'role_id' => Role::query()->where('title', 'admin')->first()->id,
            'email' => 'amirnp.1996@gmail.com',
            'password' => bcrypt('AmirBahar29762175')
        ]);
    }
}
