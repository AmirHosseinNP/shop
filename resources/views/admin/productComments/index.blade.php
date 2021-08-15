@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="d-flex align-items-center">
                        <h1 class="box-title">کامنت‌های محصول {{ $product->name }}</h1>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example5" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>کاربر</th>
                                <th>تاریخ ثبت</th>
                                <th>محتوا</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product->comments()->latest()->get() as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>{{ $comment->user->name }}</td>
                                    @php(\Carbon\Carbon::setLocale('fa_IR'))
                                    <td>{{ \App\Helpers\ConvertNumbers::convertEnglishToPersian(\Hekmatinasser\Verta\Verta::instance($comment->updated_at)->format('H:i Y/n/j')) }}</td>
                                    <td>{{ $comment->content }}</td>
                                    <td>
                                        <form action="{{ route('products.comments.destroy', ['product' => $product, 'comment' => $comment]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger btn-sm" value="حذف">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>عنوان</th>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    @include('admin.layout.errors')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- This is data table -->
    <script src="/admin/assets/vendor_components/datatable/datatables.min.js"></script>

    <!-- Superieur Admin for Data Table -->
    <script src="/admin/js/pages/data-table.js"></script>
@endsection
