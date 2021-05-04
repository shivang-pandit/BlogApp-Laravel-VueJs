<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserRoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create admin role with permission
        $role = Role::create([
            'name' => 'Admin',
            'permission' => '[{"name":"Home","read":true,"write":true,"update":true,"delete":true,"permission_route":"/admin"},{"name":"Tags","read":true,"write":true,"update":true,"delete":true,"permission_route":"/admin/tags"},{"name":"Category","read":true,"write":true,"update":true,"delete":true,"permission_route":"/admin/category"},{"name":"Blog","read":true,"write":true,"update":true,"delete":true,"permission_route":"/admin/blog"},{"name":"Admins","read":true,"write":true,"update":true,"delete":true,"permission_route":"/admin/admins"},{"name":"Role","read":true,"write":true,"update":true,"delete":true,"permission_route":"/admin/role"},{"name":"Permission","read":true,"write":true,"update":true,"delete":true,"permission_route":"/admin/permission"}]',
            'is_admin' => 1,
        ]);

        //create super admin with super role.
        $password = bcrypt('admin123');
        $admin = User::create([
            'full_name'=> 'Shivang Pandit',
            'email'=> 'shivang@yopmail.com',
            'password'=> $password,
            'role_id'=> $role->id,
            'is_activated'=> 1,
        ]);
    }
}
