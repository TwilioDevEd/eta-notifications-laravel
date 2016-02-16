<?php

use Illuminate\Database\Seeder;
use App\Order;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Order(
            ['customer_name' => 'Vincent Vega',
             'phone_number' => '+15551234567']
        ))->save();
    }
}
