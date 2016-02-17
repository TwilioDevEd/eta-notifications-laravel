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

        $this->sendMessage(
            $client,
            $order->phone_number,
            'Your clothes will be sent and will be delivered in 20 minutes'
        );
        $request->session()->flash(
            'status',
            'Message was delivered'
        );
        return redirect()->route('order.index');
    }

    public function deliver(TwilioRestClient $client, Request $request, $id) {
        $order = Order::find($id);

        $this->sendMessage(
            $client,
            $order->phone_number,
            'Your clothes have been delivered'
        );
        $request->session()->flash(
            'status',
            'Message was delivered'
        );
        return redirect()->route('order.index');
    }

    private function sendMessage($client, $to, $messageBody) {
        $twilioNumber = config('services.twilio')['number'];
        try {
            $client->account->messages->sendMessage(
                $twilioNumber, // From a Twilio number in your account
                $to, // Text any number
                $messageBody
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
