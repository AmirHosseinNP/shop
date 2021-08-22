@extends('admin.layout.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title">ایجاد اسلاید جدید</h2>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <form method="POST"
                          enctype="multipart/form-data" id="sliders-form">
                        @csrf
                        <div class="form-group">
                            <label for="image">انتخاب تصویر:</label>
                            <input type="file" class="form-control" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <label for="link">لینک مقصد:</label>
                            <input style="direction: ltr;" type="text" name="link" id="link" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="ایجاد">
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                    @include('admin.layout.errors')
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="sliders-container">
        @foreach($sliders as $slider)
            <div class="col-md-12 col-lg-3" id="slide-{{ $slider->id }}">
                <div class="card">
                    <img class="card-img-top img-responsive"
                         src="{{ str_replace('public', '/storage', $slider->image) }}" alt="slide-{{ $slider->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ route('sliders.edit', $slider) }}" class="btn btn-warning mb-10" style="width: 100%;">ویرایش</a></div>
                            <div class="col-sm-6">
                                <button class="btn btn-danger" onclick="deleteRecord({{ $slider->id }})" style="width: 100%;">حذف</button>
                            </div>
                        </div>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        $('#sliders-form').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(document.getElementById('sliders-form'));
            $.ajax({
                url: "{{ route('sliders.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (slider) {
                    let prepend =
                        '<div class="col-md-12 col-lg-3" id="slide-' + slider.id + '">' +
                            '<div class="card">' +
                                '<img class="card-img-top img-responsive"' +
                                    'src="' + slider.image.replace("public", "/storage") + '" alt="slider-' + slider.id + '">' +
                                '<div class="card-body">' +
                                    '<div class="row">' +
                                        '<div class="col-sm-6">' +
                                            '<a href="/adminpanel/sliders/' + slider.id + '/edit"' + 'class="btn btn-warning mb-10" style="width: 100%;">ویرایش</a>' +
                                        '</div>' +
                                        '<div class="col-sm-6">' +
                                            '<button style="width: 100%;" class="btn btn-danger" onclick="deleteRecord(' + slider.id + ')">حذف</button>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
                    $('#sliders-container').prepend(prepend);
                    $('input[name=image]').val("");
                    $('input[name=link]').val("");
                }
            });
        });
        function deleteRecord(sliderId) {
            if (confirm('آیا میخواهید این رکورد را حذف کنید؟')) {
                $.ajax(
                    {
                        url: '/adminpanel/sliders/' + sliderId,
                        type: 'DELETE',
                        data: {"_token": "{{ csrf_token() }}"},
                        success: function () {
                            $('#slide-' + sliderId).remove();
                        }
                    }
                )
            }
        }
    </script>
@endsection
