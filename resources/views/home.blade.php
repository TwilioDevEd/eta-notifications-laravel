@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')
<div class="full-screen-home">
    <div class="container-fluid">
        <div id="icon-row" class="row">
            <div class="col-xs-12 text-center">
                <img id="home-icon" src="/img/laundry-logo.png"/>
            </div>
        </div>
        <div id="view-orders-row" class="row">
            <div class="col-xs-12 text-center">
                <a href="{{ route('order.index') }}"><p class="btn" id="view-orders-button">VIEW ORDERS</p></a>
            </div>
        </div>
    </div>
</div>
@endsection
