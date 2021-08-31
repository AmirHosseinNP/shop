@extends('admin.layout.master')

@section('content')

    <div class="row" id="main-content">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">انتخاب دسته بندی ویژه</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('featuredCategory.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="category_id">دسته بندی مورد نظر را انتخاب کنید:</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="" disabled selected>دسته بندی مورد نظر را انتخاب کنید...</option>
                                @foreach($categories as $category)
                                    <option
                                        @if($category->id == $featuredCategory->category_id) selected @endif
                                    value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="ثبت" class="btn btn-primary">
                        </div>
                    </form>
                    @include('admin.layout.errors')
                </div>
            </div>
        </div>
    </div>

@endsection
