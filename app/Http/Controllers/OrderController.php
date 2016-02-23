<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use Services_Twilio as TwilioRestClient;
use Log;

class OrderController extends Controller
{
    public function index()
    {
        return view('index', ['orders' => Order::all()]);
    }

    public function show($id) {
        return view('show', ['order' => Order::find($id)]);
    }

    public function pickup(TwilioRestClient $client, Request $request, $id) {
        $order = Order::find($id);
        $order->status = 'Shipped';
        $order->notification_status = 'queued';
        $order->save();

        $callbackUrl = str_replace('/pickup', '', $request->url()) . '/notification/status/update';
        $this->sendMessage(
            $client,
            $order->phone_number,
            'Your clothes will be sent and will be delivered in 20 minutes',
            $callbackUrl
        );

        return redirect()->route('order.show', ['id' => $order->id]);
    }

    public function deliver(TwilioRestClient $client, Request $request, $id) {
        $order = Order::find($id);
        $order->status = 'Delivered';
        $order->notification_status = 'queued';
        $order->save();

        $callbackUrl = str_replace('/deliver', '', $request->url()) . '/notification/status/update';
        $this->sendMessage(
            $client,
            $order->phone_number,
            'Your clothes have been delivered',
            $callbackUrl
        );

        return redirect()->route('order.index');
    }

    public function notificationStatus(Request $request, $id) {
        $order = Order::find($id);
        $order->notification_status = $request->input('MessageStatus');
        $order->save();
    }

    private function sendMessage($client, $to, $messageBody, $callbackUrl) {
        $twilioNumber = config('services.twilio')['number'];
        try {
            $client->account->messages->create([
                'From' => $twilioNumber, // From a Twilio number in your account
                'To' => $to, // Text any number
                'Body' => $messageBody,
                'StatusCallback' => $callbackUrl
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
