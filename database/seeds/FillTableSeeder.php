<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dictionary')->insert([
            'word' => "Sea",
            'translate' => 'Море'
        ]);
    }
}
