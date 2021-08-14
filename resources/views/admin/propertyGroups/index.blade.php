@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="d-flex align-items-center">
                        <h1 class="box-title">گروه‌های ویژگی</h1>
                        <a href="{{ route('propertyGroups.create') }}" class="btn btn-success ml-15">ایجاد گروه ویژگی</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example5" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($propertyGroups as $propertyGroup)
                                <tr>
                                    <td>{{ $propertyGroup->id }}</td>
                                    <td>{{ $propertyGroup->title }}</td>
                                    <td><a href="{{ route('propertyGroups.edit', $propertyGroup) }}"
                                           class="btn btn-warning btn-sm">ویرایش</a></td>
                                    <td>
                                        <form action="{{ route('propertyGroups.destroy', $propertyGroup) }}" method="POST">
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
