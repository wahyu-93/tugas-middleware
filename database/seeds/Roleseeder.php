<?php

use Illuminate\Database\Seeder;
use App\Roles;

class Roleseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::create([
            'role' => '0',
        ]);

        Roles::create([
            'role' => '1',
        ]);
    }
}
