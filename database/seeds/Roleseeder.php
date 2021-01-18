<?php

use Illuminate\Database\Seeder;
use App\Role;

class Roleseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role' => '0',
        ]);

        Role::create([
            'role' => '1',
        ]);
    }
}
