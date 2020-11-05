<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Gym;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create the default administrator account.
         */
        $this->createDefaultAdminAccount();

        /**
         * TODO: Create additional factory seeders for dummy Administrators, Users, Trainers, Gyms and Videos.
         */
    }

    /**
     * Create the default administrator account.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param none
     *
     * @return Void
     */
    private function createDefaultAdminAccount() {
        User::factory(1)->state([
            'first_name' => 'Stephen',
            'last_name' => 'Medd',
            'email' => 'me@stephenmedd.co.uk',
            'phone_number' => '07480305234',
            'gender' => 'Male',
            'password' => Hash::make('H3ll0..G1r@ff3'),
            'date_of_birth' => '1995-07-14'
        ])->create();
    }
}
