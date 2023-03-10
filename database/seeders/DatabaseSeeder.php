<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            DepartmentSeeder::class,
            MunicipalitiesSeeder::class,
            UserSeeder::class,
            NationalDirectionSeeder::class,
            DependenceSeeder::class,
            ServicePlaceSeeder::class,
            TariffSeeder::class,
            EntitySeeder::class,
            TypeAgreementSeeder::class,
        ]);
    }
}
