@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">ویرایش ویژگی {{ $property->title }}</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('properties.update', $property) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="property_group_id">گروه ویژگی:</label>
                            <select name="property_group_id" id="property_group_id" class="form-control">
                                <option value="" disabled>گروه ویژگی را انتخاب کنید...</option>
                                @foreach($propertyGroups as $propertyGroup)
                                    <option
                                        @if($property->property_group_id == $propertyGroup->id) selected @endif
                                        value="{{ $propertyGroup->id }}">{{ $propertyGroup->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $property->title }}">
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
