@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="d-flex align-items-center">
                        <h1 class="box-title">ویژگی‌ها</h1>
                        <a href="{{ route('properties.create') }}" class="btn btn-success ml-15">ایجاد ویژگی</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example5" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>گروه ویژگی</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($properties as $property)
                                <tr>
                                    <td>{{ $property->id }}</td>
                                    <td>{{ $property->title }}</td>
                                    <td>{{ $property->property_group_title }}</td>
                                    <td><a href="{{ route('properties.edit', $property) }}"
                                           class="btn btn-warning btn-sm">ویرایش</a></td>
                                    <td>
                                        <form action="{{ route('properties.destroy', $property) }}" method="POST">
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
                                <th>گروه مشخصات</th>
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
