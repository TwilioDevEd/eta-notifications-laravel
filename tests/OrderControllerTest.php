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

    public function testPickup() {
        // Given
        $this->startSession();
        $order = new Order([
            'customer_name' => 'Mia Wallace',
            'phone_number' => '+15551231234'
        ]);
        $order->save();

        $this->assertCount(1, Order::all());

        $mockTwilioService = Mockery::mock('Services_Twilio')
                                ->makePartial();
        $mockTwilioAccount = Mockery::mock();
        $mockTwilioMessages = Mockery::mock();
        $mockTwilioAccount->messages = $mockTwilioMessages;
        $mockTwilioService->account = $mockTwilioAccount;

        $twilioNumber = config('services.twilio')['number'];
        $mockTwilioMessages
            ->shouldReceive('sendMessage')
            ->with($twilioNumber,
                   $order->phone_number,
                   'Your clothes will be sent and will be delivered in 20 minutes'
            )
            ->once();

        $this->app->instance(
            'Services_Twilio',
            $mockTwilioService
        );

        // When
        $response = $this->call(
            'POST',
            route('order.pickup', ['id' => $order->id]),
            ['_token' => csrf_token()]
        );

        // Then
        $this->assertRedirectedToRoute('order.index');
        $this->assertSessionHas('status');
        $flashreservation = $this->app['session']->get('status');
        $this->assertEquals(
            $flashreservation,
            'Message was delivered'
        );
    }

    public function testDeliver() {
        // Given
        $this->startSession();
        $order = new Order([
            'customer_name' => 'Marsellus Wallace',
            'phone_number' => '+15551231234'
        ]);
        $order->save();

        $this->assertCount(1, Order::all());

        $mockTwilioService = Mockery::mock('Services_Twilio')
                                ->makePartial();
        $mockTwilioAccount = Mockery::mock();
        $mockTwilioMessages = Mockery::mock();
        $mockTwilioAccount->messages = $mockTwilioMessages;
        $mockTwilioService->account = $mockTwilioAccount;

        $twilioNumber = config('services.twilio')['number'];
        $mockTwilioMessages
            ->shouldReceive('sendMessage')
            ->with($twilioNumber,
                   $order->phone_number,
                   'Your clothes have been delivered')
            ->once();

        $this->app->instance(
            'Services_Twilio',
            $mockTwilioService
        );

        // When
        $response = $this->call(
            'POST',
            route('order.deliver', ['id' => $order->id]),
            ['_token' => csrf_token()]
        );

        // Then
        $this->assertRedirectedToRoute('order.index');
        $this->assertSessionHas('status');
        $flashreservation = $this->app['session']->get('status');
        $this->assertEquals(
            $flashreservation,
            'Message was delivered'
        );
    }
}
