@extends('layouts.admin')

@section('title', 'Sign In')

@section('head')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/iCheck/flat/green.css') }}">
@endsection

@section('content')

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>{{ __('') }}</b> {{ __('Stationery') }}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ __('Sign in to start your session') }}</p>
            {{ Form::open(['route' => ['login'], 'method' => 'post']) }}
                <div class="form-group has-feedback">
                    {{ Form::email('email', old('email'), ['autofocus', 'required', 'class' => 'form-control', 'placeholder' => 'Email']) }}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    {{ Form::password('password',['required', 'class' => 'form-control', 'placeholder' => 'Password']) }}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-7">
                        <div class="checkbox icheck">
                            <label>
                                {{ Form::checkbox('remember', null, old('remember') ? 'checked' : '') }} {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-5">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            {{ __('Sign In') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            {{ Form::close() }}
            <a href="{{ route('password.request') }}">
                {{ __('I forgot my password') }}
            </a><br>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection

@section('script')
    <!-- iCheck -->
    <script src="{{ asset('AdminLTE/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
@endsection
