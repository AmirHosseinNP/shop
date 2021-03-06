@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">ویرایش دسته بندی {{ $category->title }}</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="category_id">دسته والد</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="" disabled selected>دسته والد را انتخاب کنید...</option>
                                @foreach($categories as $parent)
                                    @if($parent->id == $category->id)
                                        @continue
                                    @endif
                                    <option
                                        @if($parent->id == $category->category_id) selected @endif
                                    value="{{ $parent->id }}">{{ $parent->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="text" name="title" id="title" class="form-control"
                                   value="{{ $category->title }}">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="mb-15">گروه‌های ویژگی را انتخاب کنید:</label>
                                </div>
                                @foreach($propertyGroups as $propertyGroup)
                                    <div class="col-sm-4">
                                        <input
                                            @if($category->hasPropertyGroup($propertyGroup->title)) checked @endif
                                            value="{{ $propertyGroup->id }}" type="checkbox" name="property_groups[]"
                                            id="{{ $propertyGroup->title }}">
                                        <label for="{{ $propertyGroup->title }}">{{ $propertyGroup->title }}</label>
                                    </div>
                                @endforeach
                            </div>
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
