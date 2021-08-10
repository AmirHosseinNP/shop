@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">ایجاد نقش</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">عنوان:</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 mb-10">
                                    <label>انتخاب دسترسی‌ها:</label>
                                </div>
                                @foreach($permissions as $permission)
                                    <div class="col-sm-3">
                                        <input class="form-control" type="checkbox" name="permissions[]"
                                               id="{{ $permission->title }}" value="{{ $permission->id }}">
                                        <label for="{{ $permission->title }}">{{ $permission->label }}</label>
                                    </div>
                                @endforeach
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
