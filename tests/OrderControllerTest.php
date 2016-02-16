<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Order;

class OrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        // Given
        $order1 = new Order([
            'customer_name' => 'Mia Wallace',
            'phone_number' => '+15551231234'
        ]);
        $order1->save();
        $order2 = new Order([
            'customer_name' => 'Marsellus Wallace',
            'phone_number' => '+15551234321'
        ]);
        $order2->save();

        // When
        $this->visit('/')
             ->see('Mia Wallace')
             ->see('Marsellus Wallace');
    }
}
