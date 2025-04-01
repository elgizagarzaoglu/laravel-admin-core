<?php

namespace Database\Seeders;

use BalajiDharma\LaravelMenu\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminCoreSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'admin user',
            'permission list',
            'permission create',
            'permission edit',
            'permission delete',
            'role list',
            'role create',
            'role edit',
            'role delete',
            'user list',
            'user create',
            'user edit',
            'user delete',
            'menu list',
            'menu create',
            'menu edit',
            'menu delete',
            'menu.item list',
            'menu.item create',
            'menu.item edit',
            'menu.item delete',
            'activitylog list',
            'activitylog delete',
            
            'map list',
            'map create',
            'map edit',
            'map delete',
            
            'inventory list',
            'inventory create',
            'inventory edit',
            'inventory delete',
            
            'inventorycat list',
            'inventorycat create',
            'inventorycat edit',
            'inventorycat delete',
            
            'inventorygroup list',
            'inventorygroup create',
            'inventorygroup edit',
            'inventorygroup delete',
            
            'inventoryunit list',
            'inventoryunit create',
            'inventoryunit edit',
            'inventoryunit delete',
            
            'device list',
            'device create',
            'device edit',
            'device delete',
            
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $role1 = Role::firstOrCreate(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $role2 = Role::firstOrCreate(['name' => 'admin']);
        foreach ($permissions as $permission) {
            $role2->givePermissionTo($permission);
        }

        // create roles and assign existing permissions
        $role3 = Role::firstOrCreate(['name' => 'writer']);
        $role3->givePermissionTo('admin user');
        foreach ($permissions as $permission) {
            if (Str::contains($permission, 'list')) {
                $role3->givePermissionTo($permission);
            }
        }

        // create demo users
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'superadmin@casra.az'],
            array_merge(\App\Models\User::factory()->raw(), [
                'name' => 'Super Admin',
                'email' => 'superadmin@casra.az'
            ])
        );
        $user->assignRole($role1);

        $user = \App\Models\User::firstOrCreate(
            ['email' => 'admin@casra.az'],
            array_merge(\App\Models\User::factory()->raw(), [
                'name' => 'Admin User',
                'email' => 'admin@casra.az'
            ])
        );
        $user->assignRole($role2);

        $user = \App\Models\User::firstOrCreate(
            ['email' => 'test@casra.az'],
            array_merge(\App\Models\User::factory()->raw(), [
                'name' => 'Example User',
                'email' => 'test@casra.az'
            ])
        );
        $user->assignRole($role3);

        // create menu
        $menu = Menu::firstOrCreate(
            ['machine_name' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Admin Menu',
            ]
        );

        $menu_items = [
            [
                'name' => 'Ümumi monitoring',
                'uri' => '/<admin>/general',
                'enabled' => 1,
                'weight' => 0,
                'icon' => 'M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z',
            ],
            [
                'name' => 'Quyuların Statusu',
                'uri' => '/<admin>/wellstatus',
                'enabled' => 1,
                'weight' => 0,
                'icon' => 'M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z',
            ],
            [
                'name' => 'Xəritə',
                'uri' => '/<admin>/map',
                'enabled' => 1,
                'weight' => 0,
                'icon' => 'M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z',
            ],
            [
                'name' => 'Quyular',
                'uri' => '/<admin>/map/maplist',
                'enabled' => 1,
                'weight' => 0,
                'icon' => 'M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z',
            ],
            [
                'name' => 'İnv Vahid',
                'uri' => '/<admin>/inventoryunit',
                'enabled' => 1,
                'weight' => 0,
                'icon' => 'M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z',
            ],
            [
                'name' => 'İnv Kateqoriya',
                'uri' => '/<admin>/inventorycat',
                'enabled' => 1,
                'weight' => 10,
                'icon' => 'M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z',
            ],
            [
                'name' => 'İnv Qrup',
                'uri' => '/<admin>/inventorygroup',
                'enabled' => 1,
                'weight' => 10,
                'icon' => 'M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z',
            ],
            [
                'name' => 'İnventarlar',
                'uri' => '/<admin>/inventory',
                'enabled' => 1,
                'weight' => 10,
                'icon' => 'M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z',
            ],
            [
                'name' => 'Permissions',
                'uri' => '/<admin>/permission',
                'enabled' => 1,
                'weight' => 11,
                'icon' => 'M12,12H19C18.47,16.11 15.72,19.78 12,20.92V12H5V6.3L12,3.19M12,1L3,5V11C3,16.55 6.84,21.73 12,23C17.16,21.73 21,16.55 21,11V5L12,1Z',
            ],
            [
                'name' => 'Roles',
                'uri' => '/<admin>/role',
                'enabled' => 1,
                'weight' => 12,
                'icon' => 'M12,5.5A3.5,3.5 0 0,1 15.5,9A3.5,3.5 0 0,1 12,12.5A3.5,3.5 0 0,1 8.5,9A3.5,3.5 0 0,1 12,5.5M5,8C5.56,8 6.08,8.15 6.53,8.42C6.38,9.85 6.8,11.27 7.66,12.38C7.16,13.34 6.16,14 5,14A3,3 0 0,1 2,11A3,3 0 0,1 5,8M19,8A3,3 0 0,1 22,11A3,3 0 0,1 19,14C17.84,14 16.84,13.34 16.34,12.38C17.2,11.27 17.62,9.85 17.47,8.42C17.92,8.15 18.44,8 19,8M5.5,18.25C5.5,16.18 8.41,14.5 12,14.5C15.59,14.5 18.5,16.18 18.5,18.25V20H5.5V18.25M0,20V18.5C0,17.11 1.89,15.94 4.45,15.6C3.86,16.28 3.5,17.22 3.5,18.25V20H0M24,20H20.5V18.25C20.5,17.22 20.14,16.28 19.55,15.6C22.11,15.94 24,17.11 24,18.5V20Z',
            ],
            [
                'name' => 'Users',
                'uri' => '/<admin>/user',
                'enabled' => 1,
                'weight' => 13,
                'icon' => 'M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z',
            ],
            [
                'name' => 'Menus',
                'uri' => '/<admin>/menu',
                'enabled' => 1,
                'weight' => 14,
                'icon' => 'M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z',
            ],
        ];

        foreach ($menu_items as $item) {
            $menu->menuItems()->updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
