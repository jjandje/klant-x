<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\BackpackUser;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
        	'Webmaster',
	        'Admin',
	        'Coach',
	        'Companyowner',
	        'User',
        ];

        $permissions = [

        	'dashboard'                 => ['Webmaster', 'Admin', 'Coach', 'Companyowner', 'User'], // Webmaster, Admin, Coach, Companyowner, User
	        'profile'                   => ['Webmaster', 'Admin', 'Coach', 'Companyowner', 'User'], // Webmaster, Admin, Coach, Companyowner, User
	        'profile-goals'             => ['Webmaster', 'Admin', 'Coach', 'Companyowner', 'User'], // Webmaster, Admin, Coach, Companyowner, User
	        'profile-recipes'           => ['Webmaster', 'Admin', 'Coach', 'Companyowner', 'User'], // Webmaster, Admin, Coach, Companyowner, User
	        'profile-articles'          => ['Webmaster', 'Admin', 'Coach', 'Companyowner', 'User'], // Webmaster, Admin, Coach, Companyowner, User
	        'profile-coaches'           => ['Companyowner', 'User'], // Companyowner, User

	        'clients'                   => ['Coach'], // Coach

	        'manage-content'            => ['Webmaster', 'Admin', 'Coach'], // Webmaster, Admin, Coach
	            'pages'                 => ['Webmaster', 'Admin', 'Coach'], // Webmaster, Admin, Coach,
	            'menu-items'            => ['Webmaster', 'Admin'], // Webmaster, Admin
	            'goals'                 => ['Webmaster', 'Admin', 'Coach'], // Webmaster, Admin, Coach,
	            'recipes'               => ['Webmaster', 'Admin', 'Coach'], // Webmaster, Admin, Coach,
	            'recipe-categories'     => ['Webmaster', 'Admin', 'Coach'], // Webmaster, Admin, Coach
	            'articles'              => ['Webmaster', 'Admin', 'Coach'], // Webmaster, Admin, Coach
        	'manage-users'              => ['Webmaster', 'Admin'], // Webmaster, Admin
	            'companies'             => ['Webmaster', 'Admin'], // Webmaster, Admin
	            'users'                 => ['Webmaster', 'Admin'], // Webmaster, Admin
	            'roles'                 => ['Webmaster'], // Webmaster
	            'permissions'           => ['Webmaster'], // Webmaster

            'applications'              => ['Webmaster', 'Admin'], // Webmaster, Admin
            'logs'                      => ['Webmaster'], // Webmaster

            'manage-company'            => ['Companyowner'], // Companyowner
                'company'               => ['Companyowner'], // Companyowner
                'company-employees'     => ['Companyowner'], // Companyowner

            'settings'                  => ['Webmaster', 'Admin', 'Coach', 'Companyowner', 'User'], // Webmaster, Admin, Coach, Companyowner, User
		];

        foreach($roles as $role) {
        	$rolesArray[$role] = Role::create(['name' => $role, 'guard_name' => 'backpack']);
        }

        foreach($permissions as $permission => $authorized_roles) {
        	Permission::create(['name' => $permission, 'guard_name' => 'backpack']);

        	foreach($authorized_roles as $role) {
        	    $rolesArray[$role]->givePermissionTo($permission);
	        }
        }

        // set role to default users
        $user1 = BackpackUser::find(1);
        $user1->assignRole('Webmaster');
        $user2 = BackpackUser::find(2);
        $user2->assignRole('Admin');
        $user3 = BackpackUser::find(3);
        $user3->assignRole('Coach');
        $user4 = BackpackUser::find(4);
        $user4->assignRole('Companyowner');
        $user5 = BackpackUser::find(5);
        $user5->assignRole('User');
    }
}
