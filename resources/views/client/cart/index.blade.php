@extends('client.layout.master')

@section('content')
    <div id="container">
        <div class="container">
            <!-- Breadcrumb Start-->
            <ul class="breadcrumb">
                <li><a href="{{ route('client.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ route('client.cart.index') }}">سبد خرید</a></li>
            </ul>
            <!-- Breadcrumb End-->
            <div class="row">
                <!--Middle Part Start-->
                <div id="content" class="col-sm-12">
                    <h1 class="title">سبد خرید</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td class="text-center">تصویر</td>
                                <td class="text-center">نام محصول</td>
                                <td class="text-center">مدل</td>
                                <td class="text-center">تعداد</td>
                                <td class="text-center">قیمت واحد</td>
                                <td class="text-center">کل</td>
                            </tr>
                            </thead>
                            <tbody>
                            @isset($items)
                                @foreach($items as $item)
                                    <tr class="cart-item-{{ $item['product']->id }}">
                                        <td class="text-center">
                                            <a href="{{ route('client.products.show', $item['product']) }}">
                                                <img
                                                    width="75"
                                                    src="{{ str_replace('public', '/storage', $item['product']->image) }}"
                                                    alt="{{ $item['product']->name }}"
                                                    title="{{ $item['product']->name }}" class="img-thumbnail"/>
                                            </a>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <a href="{{ route('client.products.show', $item['product']) }}">{{ $item['product']->name }}</a><br/>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            {{ $item['product']->brand->name }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="input-group btn-block quantity">
                                                <input type="text" name="quantity"
                                                       value="{{ $item['quantity'] }}" size="1"
                                                       class="form-control input-quantity-{{ $item['product']->id }}"/>
                                                <span class="input-group-btn">
                                                <button type="submit" data-toggle="tooltip" title="بروزرسانی"
                                                        class="btn btn-primary"
                                                        onclick="addToCart('{{ $item['product']->slug }}', {{ $item['product']->id }})">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                                <button type="button" data-toggle="tooltip" title="حذف"
                                                        class="btn btn-danger" onClick="removeFromCart('{{ $item['product']->slug }}', {{ $item['product']->id }})">
                                                    <i class="fa fa-times-circle"></i>
                                                </button>
                                             </span>
                                            </div>
                                        </td>
                                        <td class="text-center"
                                            style="vertical-align: middle;">{{ number_format($item['product']->cost_with_discount) }}
                                            تومان
                                        </td>
                                        <td class="text-center" id="cost-with-discount-{{ $item['product']->id }}"
                                            style="vertical-align: middle;">{{ number_format($item['product']->cost_with_discount * $item['quantity']) }}
                                            تومان
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-8">
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right"><strong>جمع کل:</strong></td>
                                    <td class="text-right total-cost">
                                        @isset($total_cost)
                                            {{ number_format($total_cost) }}
                                            تومان
                                        @else
                                            0 تومان
                                        @endisset
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>کسر تخفیف:</strong></td>
                                    <td class="text-right total-discount">
                                        @isset($total_discount)
                                            {{ number_format($total_discount) }}
                                            تومان
                                        @else
                                            0 تومان
                                        @endisset
                                    </td>
                                </tr>
                                <td class="text-right"><strong>جمع کل پس از کسر تخفیف:</strong></td>
                                <td class="text-right total-cost-with-discount">
                                    @isset($total_cost_with_discount)
                                        {{ number_format($total_cost_with_discount) }}
                                        تومان
                                    @else
                                        0 تومان
                                    @endif
                                </td>
                                <tr>
                                    <td class="text-right"><strong>مالیات:</strong></td>
                                    <td class="text-right tax">
                                        @if(session()->has('cart'))
                                            {{ number_format(\App\Models\Cart::calculateTax()) }}
                                            تومان
                                        @else
                                            0 تومان
                                        @endisset
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>قابل پرداخت :</strong></td>
                                    <td class="text-right payable">
                                        @if(session()->has('cart'))
                                            {{ number_format(\App\Models\Cart::calculatePayable()) }}
                                            تومان
                                        @else
                                            0 تومان
                                        @endisset
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="buttons">
                        <div class="pull-left"><a href="index.html" class="btn btn-default">ادامه خرید</a></div>
                        <div class="pull-right"><a href="checkout.html" class="btn btn-primary">تسویه حساب</a></div>
                    </div>
                </div>
                <!--Middle Part End -->
            </div>
        </div>
    </div>

@endsection
