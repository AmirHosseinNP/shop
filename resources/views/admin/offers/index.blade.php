@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="d-flex align-items-center">
                        <h1 class="box-title">کدهای تخفیف</h1>
                        <a href="{{ route('offers.create') }}" class="btn btn-success ml-15">ایجاد کد تخفیف</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example5" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>کد</th>
                                <th>تاریخ آغاز</th>
                                <th>تاریخ پایان</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($offers as $offer)
                                <tr>
                                    <td>{{ $offer->id }}</td>
                                    <td>{{ $offer->code }}</td>
                                    <td class="text-center" style="direction: ltr">
                                        {{ \App\Helpers\ConvertNumbers::convertEnglishToPersian(\Hekmatinasser\Verta\Verta::instance($offer->starts_at)->format('Y/n/j H:i')) }}
                                    </td>
                                    <td class="text-center" style="direction: ltr">
                                        {{ \App\Helpers\ConvertNumbers::convertEnglishToPersian(\Hekmatinasser\Verta\Verta::instance($offer->expires_at)->format('Y/n/j H:i')) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('offers.edit', $offer) }}"
                                           class="btn btn-warning btn-sm">ویرایش</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('offers.destroy', $offer) }}" method="POST">
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
                                <th>کد</th>
                                <th>تاریخ آغاز</th>
                                <th>تاریخ پایان</th>
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
