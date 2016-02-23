@extends('layouts.master')

@section('title')
    {{ $order->customer_name }}'s Order
@endsection

@section('content')
<div class="container">
    <h2>{{ $order->customer_name }}</h2>
    <div class="row">
        <div class="col-md-2 strong">Phone Number:</div>
        <div class="col-md-10">{{ $order->phone_number }}</div>
    </div>
    <div class="row">
        <div class="col-md-2 strong">Status:</div>
        <div class="col-md-10">{!! Html::renderStatus($order->status) !!}</div>
    </div>
    <div class="row">
        <div class="col-md-2 strong">Notification Status:</div>
        <div class="col-md-10">{!! Html::renderNotificationStatus($order->notification_status) !!}</div>
    </div>
    <div class="row">
        <div class="col-md-12 top-buffer">
            {{ Form::open(array('route' => array('order.pickup', $order->id), 'method' => 'post')) }}
                <button type="submit" class="btn btn btn-info full-width">Pick up the package</button>
            {{ Form::close() }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 top-buffer">
            {{ Form::open(array('route' => array('order.deliver', $order->id), 'method' => 'post')) }}
                <button type="submit" class="btn btn btn-primary full-width">Deliver the package</button>
            {{ Form::close() }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 top-buffer">
            {{ Html::linkRoute(
                'order.index',
                '',
                [],
                ['class' => 'fa fa-arrow-left fa-4x']
            ) }}
        </div>
    </div>
</div>
@endsection
