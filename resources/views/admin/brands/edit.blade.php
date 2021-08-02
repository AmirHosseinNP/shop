@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">ویرایش برند {{ $brand->name }}</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name">نام برند:</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ $brand->name }}">
                        </div>
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <label for="image">تصویر مورد نظر را انتخاب کنید:</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{ str_replace('public', '/storage', $brand->image) }}"
                                         alt="تصویر برند {{ $brand->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="ایجاد" class="btn btn-primary">
                        </div>
                    </form>
                    @include('admin.layout.errors')
                </div>
            </div>
        </div>
    </div>
@endsection
