@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">ویرایش نقش</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="title">عنوان:</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $role->title }}">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 mb-10">
                                    <label>انتخاب دسترسی‌ها:</label>
                                </div>
                                @foreach($permissions as $permission)
                                    <div class="col-sm-3">
                                        <input
                                            @if($role->hasPermission($permission)) checked @endif
                                            class="form-control" type="checkbox" name="permissions[]"
                                            id="{{ $permission->title }}" value="{{ $permission->id }}">
                                        <label for="{{ $permission->title }}">{{ $permission->label }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="ثبت" class="btn btn-warning">
                        </div>
                    </form>
                    @include('admin.layout.errors')
                </div>
            </div>
        </div>
    </div>
@endsection
