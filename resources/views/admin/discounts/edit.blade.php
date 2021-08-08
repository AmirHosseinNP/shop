@extends('admin.layout.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title">ویرایش تخفیف</h2>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <form method="POST" action="{{ route('products.discounts.update', ['product' => $product, 'discount' => $discount]) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group col-sm-6">
                            <label for="value">مقدار تخفیف را وارد کنید</label>
                            <input type="number" class="form-control" name="value" id="value" value="{{ $discount->value }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="submit" class="btn btn-warning" value="ویرایش">
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                    @include('admin.layout.errors')
                </div>
            </div>
        </div>
    </div>
@endsection
