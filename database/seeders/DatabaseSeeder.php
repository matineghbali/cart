<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'admin User',
            'email' => 'matin.eghbali74@gmail.com',
        ]);
        User::factory()->create([
            'name' => 'client User',
            'email' => 'test@gmail.com',
        ]);
        $role = Role::create(['name' => 'admin']);
        $user->assignRole([$role->id]);
    }
}
