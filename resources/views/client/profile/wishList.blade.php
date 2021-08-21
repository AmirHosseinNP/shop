@extends('client.layout.master')

@section('links')
    <style>
        td.text-center {
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('content')
    <div id="container">
        <div class="container">
            <!-- Breadcrumb Start-->
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="fa fa-home"></i></a></li>
                <li><a href="#">حساب کاربری</a></li>
                <li><a href="wishlist.html">لیست علاقه مندی من</a></li>
            </ul>
            <!-- Breadcrumb End-->
            <div class="row">
                <!--Middle Part Start-->
                <div id="content" class="col-sm-12">
                    <h1 class="title">لیست علاقه‌مندی‌ها</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">تصویر</th>
                                <th class="text-center">نام محصول</th>
                                <th class="text-center">دسته بندی</th>
                                <th class="text-center">قیمت واحد</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($likedProducts as $product)
                                <tr id="product-{{ $product->id }}">
                                    <td class="text-center"><a href="{{ route('products.show', $product) }}"><img
                                                src="{{ str_replace('public', '/storage', $product->image) }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}" width="50"/></a>
                                    </td>
                                    <td class="text-center"><a
                                            href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                                    <td class="text-center">{{ $product->category->title }}</td>
                                    <td class="text-center">
                                        <div class="price"> {{ number_format($product->cost) }} تومان</div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-primary" title="" data-toggle="tooltip"
                                                onClick="cart.add('48');" type="button"
                                                data-original-title="افزودن به سبد"><i class="fa fa-shopping-cart"></i>
                                        </button>
                                        <a href="javascript:void(0)" class="btn btn-danger" title="حذف"
                                           data-original-title="حذف" onclick="dislike('{{ $product->slug }}', {{ $product->id }})"><i class="fa fa-times"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Middle Part End -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function dislike(productSlug, productId) {
            @auth
                $.ajax({
                url: '/likes/' + productSlug,
                type: 'DELETE',
                data: {"_token": "{{ csrf_token() }}"},
                success: function (data) {
                    $('#product-' + productId).remove();
                    $('#likes-count').html(data.likes_count);
                }
            })
            @endauth
        }
    </script>
@endsection
