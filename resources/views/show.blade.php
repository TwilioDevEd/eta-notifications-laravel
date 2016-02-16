@extends('layouts.master')

@section('title')
    {{ $order->customer_name }}'s Order
@endsection

@section('content')
<div class="container">
    <h2>{{ $order->customer_name }}</h2>
    <h4>{{ $order->phone_number }}</h4>
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
                <button type="submit" class="btn btn btn-primary full-width">Deliver up the package</button>
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
