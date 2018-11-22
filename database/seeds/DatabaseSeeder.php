<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AlumnosTableSeeder::class);
         $this->call(DocentesTableSeeder::class);
         $this->call(AdminsTableSeeder::class);
         $this->call(GradosTableSeeder::class);
         $this->call(MateriasTableSeeder::class);
         $this->call(PeriodosTableSeeder::class);
    }
}
