<?php

use Illuminate\Database\Seeder;
use App\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Customer(
            ['name' => 'Vincent Vega',
             'phone_number' => '+15551234567']
        ))->save();
    }
}
