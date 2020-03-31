<?php

use Illuminate\Database\Seeder;

use App\Debtor;
use App\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UsersTableSeeder::class);

        if (App::environment('local', 'testing', 'staging')) {
            factory(Debtor::class, 100)->create();
            factory(Employee::class, 1000)->create();
        }
    }
}