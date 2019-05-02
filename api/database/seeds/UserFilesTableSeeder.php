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
//        factory(\App\Models\UserFiles::class, 2500)->create();

        for($i = 0; $i < 1667; $i++) {
            $bulk = factory(\App\Models\UserFiles::class, 3000)->make();
            \App\Models\UserFiles::insert($bulk->toArray());
        }

//        $bulk = factory(\App\Models\UserFiles::class, 25000)->make();
//        \App\Models\UserFiles::insert($bulk->toArray());
    }
}
