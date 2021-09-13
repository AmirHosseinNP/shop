@extends('client.layout.master')

@section('content')

    <div id="container">
        <div class="container">
            <!-- Breadcrumb Start-->
            <ul class="breadcrumb">
                <li><a href="{{ route('client.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ route('client.cart.index') }}">سبد خرید</a></li>
                <li><a href="{{ route('client.orders.create') }}">ثبت سفارش</a></li>
            </ul>
            <!-- Breadcrumb End-->
            <div class="row">
                <h1 class="title">ثبت سفارش</h1>
                <form action="{{ route('client.orders.store') }}" method="POST" id="order-store">
                    @csrf
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><i class="fa fa-ticket"></i> استفاده از کوپن تخفیف</h4>
                            </div>
                            <div class="panel-body">
                                <label for="offer-code" class="col-sm-3 control-label">کد تخفیف خود را وارد
                                    کنید</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="offer-code"
                                           placeholder="کد تخفیف خود را در اینجا وارد کنید" value="" name="offer-code">
                                    <span class="input-group-btn">
                          <input type="button" class="btn btn-primary" data-loading-text="بارگذاری ..."
                                 id="button-coupon" value="اعمال کوپن">
                          </span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><i class="fa fa-shopping-cart"></i> سبد خرید</h4>
                            </div>
                            <div class="panel-body">
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
                                        <tbody id="cart-table">
                                        @if(isset($items))
                                            @foreach($items as $item)
                                                @php
                                                    $product = $item['product'];
                                                    $quantity = $item['quantity'];
                                                @endphp
                                                <tr class="cart-item-{{ $product->id }}">
                                                    <td class="text-center">
                                                        <a href="{{ route('client.products.show', $product) }}">
                                                            <img
                                                                width="75"
                                                                src="{{ str_replace('public', '/storage', $product->image) }}"
                                                                alt="{{ $product->name }}"
                                                                title="{{ $product->name }}" class="img-thumbnail"/>
                                                        </a>
                                                    </td>
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <a href="{{ route('client.products.show', $product) }}">{{ $product->name }}</a><br/>
                                                    </td>
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        {{ $product->brand->name }}
                                                    </td>
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <div class="input-group btn-block quantity">
                                                            <input type="number" name=""
                                                                   value="{{ $quantity }}" size="1"
                                                                   class="form-control input-quantity-{{ $product->id }}"/>
                                                            <span class="input-group-btn">
                                                <button type="button" data-toggle="tooltip" title="بروزرسانی"
                                                        class="btn btn-primary"
                                                        onclick="addToCart('{{ $product->slug }}', {{ $product->id }})">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                                <button type="button" data-toggle="tooltip" title="حذف"
                                                        class="btn btn-danger"
                                                        onClick="removeFromCart('{{ $product->slug }}', {{ $product->id }})">
                                                    <i class="fa fa-times-circle"></i>
                                                </button>
                                             </span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"
                                                        style="vertical-align: middle;">{{ number_format($product->cost_with_discount) }}
                                                        تومان
                                                    </td>
                                                    <td class="text-center" id="cost-with-discount-{{ $product->id }}"
                                                        style="vertical-align: middle;">{{ number_format($product->cost_with_discount * $quantity) }}
                                                        تومان
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-pencil"></i>
                                    آدرس خود را وارد نمایید
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                <textarea name="address" rows="5" id="address" class="form-control"
                                          style="resize: vertical"></textarea>
                                </div>
                                <div>
                                    <input type="submit" class="btn btn-primary" value="تایید سفارش">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#order-store').submit(function () {
            for (let x in sessionStorage) {
                sessionStorage.removeItem(x);
            }
            return true;
        });
    </script>
@endsection
