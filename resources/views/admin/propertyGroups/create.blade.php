@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">ایجاد گروه ویژگی</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('propertyGroups.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="text" name="title" id="title" class="form-control">
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
