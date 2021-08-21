@extends('admin.layout.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title">اضافه کردن تصویر جدید</h2>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <form method="POST" action="{{ route('products.pictures.store', $product) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="path">انتخاب تصویر:</label>
                            <input type="file" class="form-control" name="image" id="path">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="آپلود">
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                    @include('admin.layout.errors')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($product->pictures as $picture)
            <div class="col-md-12 col-lg-3" id="picture-{{ $picture->id }}">
                <div class="card">
                    <img class="card-img-top img-responsive"
                         src="{{ str_replace('public', '/storage', $picture->path) }}" alt="{{ $product->name }}">
                    <div class="card-body">
                        {{--                        <form--}}
                        {{--                            action="{{ route('products.pictures.destroy', ['product' => $product, 'picture' => $picture]) }}"--}}
                        {{--                            method="POST"--}}
                        {{--                            class="d-inline">--}}
                        {{--                            @csrf--}}
                        {{--                            @method('DELETE')--}}
                        {{--                            <input type="submit" class="btn btn-danger" value="حذف">--}}
                        {{--                        </form>--}}
                        <button class="btn btn-danger"
                                onclick="deleteRecord('{{ $product->slug }}', {{ $picture->id }})">حذف
                        </button>
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
        function deleteRecord(productSlug, pictureId) {
            if (confirm('آیا میخواهید این رکورد را حذف کنید؟')) {
                $.ajax(
                    {
                        url: '/adminpanel/products/' + productSlug + '/pictures/' + pictureId,
                        type: 'DELETE',
                        data: {"_token": "{{ csrf_token() }}"},
                        success: function () {
                            $('#picture-' + pictureId).remove();
                        }
                    }
                )
            }
        }
    </script>
@endsection
