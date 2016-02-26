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
        $this->visit('/orders')
             ->see('Mia Wallace')
             ->see('Marsellus Wallace')
             ->see('Ready');
    }

    public function testPickup() {
        // Given
        $this->startSession();
        $order = new Order([
            'customer_name' => 'Mia Wallace',
            'phone_number' => '+15551231234'
        ]);
        $order->save();
        $order = $order->fresh();
        $this->assertEquals('Ready', $order->status);
        $this->assertEquals('None', $order->notification_status);
        $this->assertCount(1, Order::all());

        $mockTwilioService = Mockery::mock('Services_Twilio')
                                ->makePartial();
        $mockTwilioAccount = Mockery::mock();
        $mockTwilioMessages = Mockery::mock();
        $mockTwilioAccount->messages = $mockTwilioMessages;
        $mockTwilioService->account = $mockTwilioAccount;

        $twilioNumber = config('services.twilio')['number'];
        $mockTwilioMessages
            ->shouldReceive('create')
            ->with([
                'From' => $twilioNumber,
                'To' => $order->phone_number,
                'Body' => 'Your laundry is done and on its way to you!',
                'StatusCallback' => "http://localhost/order/{$order->id}/notification/status/update"
            ])->once();

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
        $order = $order->fresh();
        $this->assertEquals('Shipped', $order->status);
        $this->assertEquals('queued', $order->notification_status);
        $this->assertRedirectedToRoute('order.show', ['id' => $order->id]);
    }

    public function testDeliver() {
        // Given
        $this->startSession();
        $order = new Order([
            'customer_name' => 'Marsellus Wallace',
            'phone_number' => '+15551231234'
        ]);
        $order->save();
        $order = $order->fresh();

        $this->assertEquals('Ready', $order->status);
        $this->assertEquals('None', $order->notification_status);
        $this->assertCount(1, Order::all());

        $mockTwilioService = Mockery::mock('Services_Twilio')
                                ->makePartial();
        $mockTwilioAccount = Mockery::mock();
        $mockTwilioMessages = Mockery::mock();
        $mockTwilioAccount->messages = $mockTwilioMessages;
        $mockTwilioService->account = $mockTwilioAccount;

        $twilioNumber = config('services.twilio')['number'];
        $mockTwilioMessages
            ->shouldReceive('create')
            ->with([
                'From' => $twilioNumber,
                'To' => $order->phone_number,
                'Body' => 'Your laundry is arriving now.',
                'StatusCallback' => "http://localhost/order/{$order->id}/notification/status/update"
            ])->once();

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
        $order = $order->fresh();
        $this->assertEquals('Delivered', $order->status);
        $this->assertEquals('queued', $order->notification_status);
        $this->assertRedirectedToRoute('order.index');
    }

    public function testNotificationStatus() {
        // Given
        $this->startSession();
        $order = new Order([
            'customer_name' => 'Marsellus Wallace',
            'phone_number' => '+15551231234'
        ]);
        $order->save();
        $order = $order->fresh();

        $this->assertCount(1, Order::all());
        $this->assertEquals('Ready', $order->status);
        $this->assertEquals('None', $order->notification_status);

        // When
        $response = $this->call(
            'POST',
            route('order.notification.status', ['id' => $order->id, 'MessageStatus' => 'sent']),
            ['_token' => csrf_token()]
        );

        // Then
        $order = $order->fresh();
        $this->assertEquals('Ready', $order->status);
        $this->assertEquals('sent', $order->notification_status);
    }
}
