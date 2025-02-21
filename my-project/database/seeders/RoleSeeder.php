<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name'        => 'Super Admin',
                'slug'        => 'super-admin',
                'description' => 'The Super Admin has the highest level of access in the system. This role can:
                                Manage all users, including administrators.
                                Assign and revoke roles.
                                Access and modify all system settings.
                                Manage security policies and permissions.
                                Oversee the entire platform, including backups and data management.'
            ],
            [
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'The Admin has a high level of control but with some restrictions compared to the Super Admin. This role can:
                                    Manage users except for the Super Admin.
                                    Assign roles except for the Super Admin role.
                                    Configure system settings related to users and content.
                                    Approve and moderate content.
                                    View and manage reports and logs.'
            ],
            [
                'name'        => 'Editor',
                'slug'        => 'editor',
                'description' => 'The Editor has permissions to manage and publish content but has limited administrative access. This role can:
                                    Create, edit, and publish content.
                                    Moderate and approve user-submitted content.
                                    View analytics and content performance reports.
                                    Cannot manage users or system settings.'
            ],
            [
                'name'        => 'Duide',
                'slug'        => 'guide',
                'description' => 'A Guide is a knowledgeable individual responsible for leading and assisting groups of tourists during their travels.
                                    Guides provide valuable information about local history, culture, and attractions, ensuring a safe and enjoyable experience for guests.
                                    They are skilled in communication and often have expertise in specific areas, such as adventure, culture, or nature.
                                    Guides also help manage itineraries, address visitor inquiries, and ensure customer satisfaction throughout the tour.'
            ],
        ];

        foreach ($roles as $role) {

            Role::create($role);
        }
    }
}