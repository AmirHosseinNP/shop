@extends('admin.layout.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title">ویرایش اسلاید شماره {{ $slider->id }}</h2>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <form method="POST" action="{{ route('sliders.update', $slider) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="path">انتخاب تصویر:</label>
                                        <input type="file" class="form-control" name="image" id="path">
                                    </div>
                                    <div class="form-group">
                                        <label for="link">لینک مقصد:</label>
                                        <input style="direction: ltr;" type="text" name="link" id="link" value="{{ $slider->link }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success" value="ثبت">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{ str_replace('public', '/storage', $slider->image) }}"
                                         alt="slide-{{ $slider->id }}">
                                </div>
                            </div>
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
