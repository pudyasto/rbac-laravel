<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $superadminRole = Role::create(['name' => 'Administrator']);
        // gets all permissions via Gate::before rule

        $user = User::create([
            'name'          => 'Administrator',
            'username'      => 'administrator',

            'gender'        => 'Laki',
            'department'    => 'ICT',
            'status'        => 'Aktif',

            'email'         => 'mr.pudyasto@gmail.com',
            'password'      => bcrypt('12345'),

            'photo'         => null,
        ]);
        $user->assignRole($superadminRole);
    }
}
