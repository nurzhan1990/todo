<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Status;
        $role->name = 'Выполняется';
        $role->save();

        $role = new Status;
        $role->name = 'Ждет выполнения';
        $role->save();

        $role = new Status;
        $role->name = 'Выполнено';
        $role->save();

        $role = new Status;
        $role->name = 'Отменено';
        $role->save();

    }
}
