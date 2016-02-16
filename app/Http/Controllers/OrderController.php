<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use Services_Twilio as TwilioRestClient;

class OrderController extends Controller
{
    public function index()
    {
        return view('index', ['orders' => Order::all()]);
    }

    public function show($id) {
        return view('show', ['order' => Order::find($id)]);
    }

    public function pickup($id) {
        return view('index', ['orders' => Order::all()]);
    }
}
