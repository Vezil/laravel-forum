<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => 'password123',
            'remember_token' => Str::random(60)
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => 'password123',
            'remember_token' => Str::random(60)
        ]);

        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);

        $users = factory(User::class, 10)->create();

        $users->each(function ($user) use ($userRole) {
            $user->roles()->attach($userRole);
        });

    }
}
