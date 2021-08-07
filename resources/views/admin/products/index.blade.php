@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="d-flex align-items-center">
                        <h1 class="box-title">محصولات</h1>
                        <a href="{{ route('products.create') }}" class="btn btn-success ml-15">ایجاد محصول</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example5" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>دسته بندی</th>
                                <th>برند</th>
                                <th>قیمت - تومان</th>
                                <th>تاریخ ایجاد</th>
                                <th>تصویر</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->title }}</td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td class="text-center">{{ number_format($product->cost) }}</td>
                                    <td class="text-center">
                                        {{ \App\Helpers\ConvertNumbers::convertEnglishToPersian(\Hekmatinasser\Verta\Verta::instance($product->created_at)->format('H:i Y/n/j')) }}
                                    </td>
                                    <td class="text-center"><img
                                            src="{{ str_replace('public', '/storage', $product->image) }}"
                                            alt="{{ $product->name }}" width="100" height="100"></td>
                                    <td><a href="{{ route('products.edit', $product) }}"
                                           class="btn btn-warning btn-sm">ویرایش</a></td>
                                    <td>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST">
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
                                <th>نام</th>
                                <th>دسته بندی</th>
                                <th>برند</th>
                                <th>قیمت</th>
                                <th>تاریخ ایجاد</th>
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