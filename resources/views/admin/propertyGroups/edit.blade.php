@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">ویرایش گروه ویژگی {{ $propertyGroup->title }}</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('propertyGroups.update', $propertyGroup) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $propertyGroup->title }}">
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
