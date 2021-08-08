@extends('admin.layout.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title">اعمال تخفیف</h2>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <form method="POST" action="{{ route('products.discounts.store', $product) }}">
                        @csrf
                        <div class="form-group col-sm-6">
                            <label for="value">مقدار تخفیف را وارد کنید</label>
                            <input type="number" class="form-control" name="value" id="value">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="submit" class="btn btn-success" value="اعمال">
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
