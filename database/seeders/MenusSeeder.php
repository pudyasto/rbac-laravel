<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menus;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $main_menu = Menus::create([
            'menu_order'    => '100',
            'menu_header'   => 'Menu dan Pengguna',
            'menu_name'     => 'Menu Pengguna',
            'description'   => 'Manajemen menu dan pengguna aplikasi',
            'link'          => '#',
            'icon'          => ' ri-shield-user-line ',
            'main_uuid'       => null,
            'is_active'     => 'Aktif',
        ]);
        // Role to Permission
        Menus::create([
            'menu_order'    => '1',
            'menu_header'   => '',
            'menu_name'     => 'Role Pengguna',
            'description'   => 'Manajemen role pengguna',
            'link'          => 'roles',
            'icon'          => '-',
            'main_uuid'     => $main_menu->uuid,
            'is_active'     => 'Aktif',
        ]);

        Menus::create([
            'menu_order'    => '2',
            'menu_header'   => '',
            'menu_name'     => 'Menu',
            'description'   => 'Manajemen menu aplikasi',
            'link'          => 'menus',
            'icon'          => '-',
            'main_uuid'     => $main_menu->uuid,
            'is_active'     => 'Aktif',
        ]);

        // Module to Permission
        Menus::create([
            'menu_order'    => '3',
            'menu_header'   => '',
            'menu_name'     => 'Module',
            'description'   => 'Manajemen module aplikasi',
            'link'          => 'modules',
            'icon'          => '-',
            'main_uuid'     => $main_menu->uuid,
            'is_active'     => 'Aktif',
        ]);

        Menus::create([
            'menu_order'    => '4',
            'menu_header'   => '',
            'menu_name'     => 'Pengguna',
            'description'   => 'Manajemen pengguna aplikasi',
            'link'          => 'users',
            'icon'          => '-',
            'main_uuid'     => $main_menu->uuid,
            'is_active'     => 'Aktif',
        ]);
    }
}
