@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">ایجاد کد تخفیف</h1>
                </div>
                <div class="box-body">
                    <form action="{{ route('offers.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="code">کد تخفیف:</label>
                            <input type="text" name="code" id="code" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">تاریخ آغاز:</label>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <label for="start-year">سال:</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" name="starts_at[]" id="start-year"
                                                           class="form-control" maxlength="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="row align-items-center">
                                                <div class="col-2">
                                                    <label for="start-month">ماه:</label>
                                                </div>
                                                <div class="col-10">
                                                    <select name="starts_at[]" id="start-month" class="form-control">
                                                        <option value="" selected disabled>انتخاب کنید...</option>
                                                        <option value="01">فروردین</option>
                                                        <option value="02">اردیبهشت</option>
                                                        <option value="03">خرداد</option>
                                                        <option value="04">تیر</option>
                                                        <option value="05">مرداد</option>
                                                        <option value="06">شهریور</option>
                                                        <option value="07">مهر</option>
                                                        <option value="08">آبان</option>
                                                        <option value="09">آذر</option>
                                                        <option value="10">دی</option>
                                                        <option value="11">بهمن</option>
                                                        <option value="12">اسفند</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="row align-items-center">
                                                <div class="col-2">
                                                    <label for="start-day">روز:</label>
                                                </div>
                                                <div class="col-10">
                                                    <input type="text" name="starts_at[]" id="start-day"
                                                           class="form-control" maxlength="2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <label for="start-time">ساعت:</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="time" name="starts_at[]" id="start-time"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">تاریخ پایان:</label>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <label for="end-year">سال:</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" name="expires_at[]" id="end-year"
                                                           class="form-control" maxlength="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="row align-items-center">
                                                <div class="col-2">
                                                    <label for="end-month">ماه:</label>
                                                </div>
                                                <div class="col-10">
                                                    <select name="expires_at[]" id="end-month" class="form-control">
                                                        <option value="" selected disabled>انتخاب کنید...</option>
                                                        <option value="01">فروردین</option>
                                                        <option value="02">اردیبهشت</option>
                                                        <option value="03">خرداد</option>
                                                        <option value="04">تیر</option>
                                                        <option value="05">مرداد</option>
                                                        <option value="06">شهریور</option>
                                                        <option value="07">مهر</option>
                                                        <option value="08">آبان</option>
                                                        <option value="09">آذر</option>
                                                        <option value="10">دی</option>
                                                        <option value="11">بهمن</option>
                                                        <option value="12">اسفند</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="row align-items-center">
                                                <div class="col-2">
                                                    <label for="end-day">روز:</label>
                                                </div>
                                                <div class="col-10">
                                                    <input type="text" name="expires_at[]" id="end-day"
                                                           class="form-control" maxlength="2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <label for="end-time">ساعت:</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="time" name="expires_at[]" id="end-time"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
