@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">ایجاد محصول</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="category_id">دسته بندی</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="" disabled selected>دسته بندی محصول را انتخاب کنید...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="brand_id">برند</label>
                            <select name="brand_id" id="brand_id" class="form-control">
                                <option value="" disabled selected>برند محصول را انتخاب کنید...</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">نام</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="slug">اسلاگ</label>
                            <input type="text" name="slug" id="slug" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="cost">قیمت</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-left-0" id="basic-addon1">تومان</span>
                                </div>
                                <input type="number" name="cost" id="cost" class="form-control"
                                       aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">تصویر</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">شرح محصول</label>
                            <textarea name="description" id="description" class="form-control" rows="5"></textarea>
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
