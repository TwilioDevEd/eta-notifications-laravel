@extends('layouts.master')

@section('title')
    Orders
@endsection

@section('content')
@include('_messages')
<div class="container">
    <h2>Orders</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ Html::linkRoute('order.show', $order->customer_name, array($order->id)) }}</td>
                    <td>{{ $order->phone_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
