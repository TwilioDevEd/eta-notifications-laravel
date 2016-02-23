@extends('layouts.master')

@section('title')
    Orders
@endsection

@section('content')
<div class="container">
    <h2>Orders</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Phone Number</th>
                <th>Status</th>
                <th>Notification Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ Html::linkRoute('order.show', '000-0' . $order->id, array($order->id)) }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->phone_number }}</td>
                    <td>{!! Html::renderStatus($order->status) !!}</td>
                    <td>{!! Html::renderNotificationStatus($order->notification_status) !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
