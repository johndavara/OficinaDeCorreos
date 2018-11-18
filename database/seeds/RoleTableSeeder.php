<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_employee = new \App\Role();
        $role_employee->name = 'admin';
        $role_employee->description = 'A Admin User';
        $role_employee->save();

        $role_manager = new \App\Role();
        $role_manager->name = 'repartidor';
        $role_manager->description = 'A Repartidor User';
        $role_manager->save();
    }
}
