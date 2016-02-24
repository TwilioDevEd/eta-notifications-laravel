@extends('layouts.master')

@section('title')
    Orders
@endsection

@section('content')
<div class="container-fluid no-paddin">
    <div class="row" id="order-index-header">
        <div class="col-md-1 col-xs-1">
            <span class="order-index-title">ORDERS</span>
        </div>
        <div class="col-md-10 col-xs-10 text-center">
            <img id="order-index-icon" src="/img/small-logo.png"/>
        </div>
    </div>
    <div class="list-group list-special">
        @foreach ($orders as $order)
            <a href="{{ route('order.show', ['id' => $order->id]) }}" class="list-group-item list-special-item">
                <div class="row">
                    <div class="col-xs-8 text-uppercase">
                        {{ $order->customer_name }}
                    </div>
                    <div class="col-xs-3 index-status text-uppercase">
                        {{ $order->status }}
                    </div>
                    <div class="col-xs-1">
                        <i class="fa fa-caret-right"></i>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
