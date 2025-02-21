<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the super-admin role.
        $role = Role::where('slug', 'super-admin')->first();

        // Create a first user in start app that can access all the features.
        User::create([
            'role_id'       => $role->id,
            'first_name'    => config('app.super_admin_first_name'),
            'last_name'     => config('app.super_admin_last_name'),
            'email'         => config('app.super_admin_email'),
            'date_of_birth' => config('app.super_admin_date_of_birth'),
            'personal_nr'   => config('app.super_admin_personal_nr'),
            'password'      => Hash::make(config('app.super_admin_password')),
            ]);

        User::factory()->count(19)->create();
    }
}