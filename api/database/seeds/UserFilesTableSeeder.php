<?php

use Illuminate\Database\Seeder;

class UserFilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** 5000000 rows */
        for($i = 0; $i < 1667; $i++) {
            $bulk = factory(\App\Models\UserFiles::class, 3000)->make();
            \App\Models\UserFiles::insert($bulk->toArray());
        }
    }
}
