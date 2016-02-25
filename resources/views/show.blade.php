@extends('layouts.master')

@section('title')
    {{ $order->customer_name }}'s Order
@endsection

@section('content')
<div class="container-fluid">
    <div class="row" id="order-index-header">
        <div class="col-md-4 col-xs-4">
            <a href="{{ route('order.index') }}"><i class="fa fa-caret-left order-index-title"></i><span class="order-index-title">BACK</span></a>
        </div>
        <div class="col-md-4 col-xs-4 text-center">
            <img id="order-index-icon" src="/img/small-logo.png"/>
        </div>
    </div>
    <div class="row">
        <div id="house-image" class="col-md-7 col-xs-7 no-padding">
            <p id="customer-name-p">{{ $order->customer_name }}</p>
        </div>
        <div id="location-image" class="col-md-5 col-xs-5 no-padding"></div>
    </div>
    <div id="show-info-row" class="row">
        <div class="col-xs-6 no-padding">
            Status: <span class="index-status text-uppercase">{{ $order->status }}</span>
        </div>
        <div class="col-xs-6 no-padding">
            Notification: <span class="index-status text-uppercase">{{ $order->notification_status }}</span>
        </div>
    </div>
    <div class="row show-button-row">
        <div class="col-xs-12 text-center">
            {{ Form::open(array('route' => array('order.pickup', $order->id), 'method' => 'post')) }}
                <button type="submit" class="btn show-button">
                    <div class="col-xs-3 text-center">
                        <img id="order-index-icon" src="/img/small-logo.png"/>
                    </div>
                    <div class="col-xs-6 text-center">
                        PICK-UP
                    </div>
                </button>
            {{ Form::close() }}
        </div>
    </div>
    <div class="row show-button-row">
        <div class="col-xs-12 text-center">
            {{ Form::open(array('route' => array('order.deliver', $order->id), 'method' => 'post')) }}
                <button type="submit" class="btn show-button">
                    <div class="col-xs-6 col-xs-offset-3 text-center">
                        DELIVER
                    </div>
                    <div class="col-xs-3 text-center">
                        <i class="fa fa-bicycle"></i>
                    </div>
                </button>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
