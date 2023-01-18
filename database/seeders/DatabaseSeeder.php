<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        $this->truncate();
         \App\Models\User::factory(20)->create();
         \App\Models\Category::factory(20)->create();
        Schema::enableForeignKeyConstraints();

    }

    private function truncate(){
        User::truncate();
        Category::truncate();
    }
}
