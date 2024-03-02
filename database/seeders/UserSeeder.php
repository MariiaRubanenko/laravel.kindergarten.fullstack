<?php

//Создание ролей и разрешений для пользователей, также создание админа и одного учителя

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_list = Permission::create(['name'=>'user_list']);
        $user_view = Permission::create(['name'=>'user_view']);
        $user_create = Permission::create(['name'=>'user_create']);
        $user_update = Permission::create(['name'=>'user_update']);
        $user_delete = Permission::create(['name'=>'user_delete']);

        $admin_role = Role::create(['name'=> 'admin']);
        // $admin_role->givePermissionTo([
        //     $user_create,
        //     $user_list,
        //     $user_update,
        //     $user_view,
        //     $user_delete
        // ]);

        $admin = User::create([
            'name'=>'Admin',
            'email'=>'admin@admin.com',
            'password'=> bcrypt('password')
        ]);

        $admin->assignRole($admin_role);

        // $admin->givePermissionTo([
        //     $user_create,
        //     $user_list,
        //     $user_update,
        //     $user_view,
        //     $user_delete
        // ]);


        
        $teacher = User::create([
            'name'=>'teacher',
            'email'=>'teacher@teacher.com',
            'password'=> bcrypt('password')
        ]);

        $teacher_role= Role::create(['name'=> 'teacher']);
        $teacher->assignRole($teacher_role);
        
        $teacher_role->givePermissionTo([
            $user_list,
            $user_update,
        ]);

        // $teacher->givePermissionTo([
        //     $user_list,
        //     $user_update,
        // ]);

        ///////
        $parent = User::create([
            'name'=>'parent',
            'email'=>'parent@parent.com',
            'password'=> bcrypt('password')
        ]);

        $parent_role= Role::create(['name'=> 'parent']);
        $parent->assignRole($parent_role);
        
        $parent_role->givePermissionTo([
            $user_list,
        ]);

        // $parent->givePermissionTo([
        //     $user_list,
        // ]);

        ///////



    }
}
