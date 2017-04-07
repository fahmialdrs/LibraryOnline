<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //membuat role admin
        $adminrole = new Role();
        $adminrole->name= 'admin';
        $adminrole->display_name='Admin';
        $adminrole->save();

        //membuat role member
        $memberrole = new Role;
        $memberrole->name='member';
        $memberrole->display_name='Member';
        $memberrole->save();
        
        //membuat user admin
        $admin = new User();
        $admin->name= 'Super Admin';
        $admin->email= 'sa@a.com';
        $admin->password = bcrypt('sa1234');
        $admin->is_verified = 1;
        $admin->save();
        $admin->attachRole($adminrole);

        //membuat user member
        $member = new User();
        $member->name='Sample Member';
        $member->email='fahmialdrs@gmail.com';
        $member->password= bcrypt('sm1234');
        $member->is_verified = 1;
        $member->save();
        $member->attachRole($memberrole);
        
    }
}
