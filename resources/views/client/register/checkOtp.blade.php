@extends('client.layout.master')

@section('content')
    <div id="container">
        <div class="container">
            <div class="row">
                <!--Middle Part Start-->
                <div class="col-sm-12" id="content">
                    <h1 class="title">تایید کد یکبار مصرف</h1>
                    <form class="form-horizontal" method="POST" action="{{ route('client.register.verifyOtp', $user) }}">
                        @csrf
                        <fieldset id="account">
                            <div class="form-group required">
                                <label for="input-otp" class="col-sm-2 control-label">کد یکبار مصرف</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input-otp" placeholder="کد یکبار مصرف" name="otp"
                                    max="99999" min="11111" maxlength="5" minlength="5">
                                </div>
                            </div>
                        </fieldset>

                        <div class="buttons">
                            <div class="pull-right">
                                <input type="submit" class="btn btn-primary" value="تایید">
                            </div>
                        </div>
                    </form>
                </div>
                <!--Middle Part End -->
                <div class="col-sm-12">
                    @include('admin.layout.errors')
                </div>
            </div>
        </div>
    </div>
@endsection
