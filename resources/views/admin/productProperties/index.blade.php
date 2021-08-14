@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="d-flex align-items-center">
                        <h1 class="box-title">ویژگی‌های محصول {{ $product->name }}</h1>
                        <a href="{{ route('products.properties.create', $product) }}" class="btn btn-success ml-15">افزودن یا ویرایش مقادیر ویژگی‌ها</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example5" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>گروه ویژگی</th>
                                <th>عنوان</th>
                                <th>مقدار</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product->properties as $property)
                                <tr>
                                    <td>{{ $property->id }}</td>
                                    <td>{{ $property->property_group_title }}</td>
                                    <td>{{ $property->title }}</td>
                                    <td>{{ $product->getPropertyValue($property) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>گروه مشخصات</th>
                                <th>مقدار</th>
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
