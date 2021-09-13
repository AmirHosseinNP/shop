@extends('client.layout.master')

@section('content')

    @if($order->payment_status == 'OK')
        <div class="container">
            <p class="bg-success">پرداخت با موفقیت انجام شد</p>
        </div>
    @else
        <div class="container">
            <p class="bg-danger">پرداخت با موفقیت انجام نشد</p>
        </div>
    @endif

@endsection
