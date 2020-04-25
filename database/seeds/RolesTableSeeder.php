<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role;
        $role->name = 'Администратор';
        $role->slug = 'admin';
        $role->save();

        $role = new Role;
        $role->name = 'Модератор';
        $role->slug = 'moderator';
        $role->save();

        $role = new Role;
        $role->name = 'Оператор';
        $role->slug = 'operator';
        $role->save();
    }
}
