<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $data_role = [
            [
              'name'       => 'Administrator',
              'guard_name' => 'web',
              'created_at' => \Carbon\Carbon::now(),
            ],
            [
              'name'       => 'testing',
              'guard_name' => 'web',
              'created_at' => \Carbon\Carbon::now(),
            ]
        ];
        Role::truncate();
		$role = Role::insert(
			$data_role
		);
    $user = User::find('1');
    $user->assignRole('Administrator');
        $role_first = Role::first();

        $permissions = [
    		    [
                'name'       => 'dashboard',
                'guard_name' => 'web',
                'action'     => ['view'],
            ],
            [
                'name'       => 'setting',
                'guard_name' => 'web',
                'action'     => ['view', 'add', 'edit', 'delete'],
            ],
    		    [
                'name'       => 'role',
                'guard_name' => 'web',
                'action'     => ['view', 'add', 'edit', 'delete'],
            ],
            [
                'name'       => 'user',
                'guard_name' => 'web',
                'action'     => ['view', 'add', 'edit', 'delete'],
            ],
            [
                'name'       => 'anggota',
                'guard_name' => 'web',
                'action'     => ['view', 'add', 'edit', 'delete'],
            ],
            [
                'name'       => 'pencarian',
                'guard_name' => 'web',
                'action'     => ['view'],
            ],
            [
              'name'       => 'Kelompok',
              'guard_name' => 'web',
              'action'     => ['view'],
          ],
        ];
        Permission::truncate();
        foreach ($permissions as $row) {
            foreach ($row['action'] as $key => $val) {
                $temp = [
                    'name'       => $row['name'].'-'.$val,
                    'guard_name' => $row['guard_name']
    			];	
    			// create permission and assign to role
    			$perms = Permission::create($temp);
    			$role_first->givePermissionTo($perms);

    		}
    	}
    }
}
