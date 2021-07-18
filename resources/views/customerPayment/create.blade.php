@extends('layouts.admin')

@section('title', __('Create New Customer Payment'))

@section('head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-money"></i> {{ __('Customer Payments') }}
                <small>{{ __('Create') }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.customerPayments.index') }}">{{ __('Customer Payments') }}</a></li>
                <li class="active">{{ __('Create') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- right column -->
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __('Create New Customer Payment') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        {{ Form::model($payment, ['route' => ['dashboard.customerPayments.store'], 'method' => 'post', 'autocomplete' => 'off']) }}
                        <div class="box-body">
                            @if(isset($payment->customer_id))
                                <div class="form-group">
                                    {{ Form::label('customer_id', __('Supplier') . ':', ['class' => 'control-label']) }}
                                    {{ Form::hidden('customer_id') }}
                                    <h4>{{ $payment->customer->company  }}</h4>
                                </div>
                            @else
                                <div class="form-group {{ $errors->has('customer_id')? 'has-error' : '' }}">
                                    @if($errors->has('customer_id'))
                                        <i class="fa fa-times-circle-o"></i>
                                    @endif
                                    {{ Form::label('customer_id', __('Customer') . ':', ['class' => 'control-label']) }}
                                    {{ Form::select('customer_id', $customers, null, ['required', $payment->customer_id? 'readonly':'', 'class' => 'form-control select2 customer', 'placeholder' => __('Select Customer') . '...']) }}
                                    <span class="help-block">{{ $errors->first('customer_id') }}</span>
                                </div>
                            @endif
                            <div class="form-group {{ $errors->has('date')? 'has-error' : '' }}">
                                @if($errors->has('date'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('date', __('Date') . ':', ['class' => 'control-label']) }}
                                {{ Form::date('date', old('date'), ['required', 'class' => 'form-control', 'placeholder' => __('Select Date') . '...']) }}
                                <span class="help-block">{{ $errors->first('date') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('time')? 'has-error' : '' }}">
                                @if($errors->has('time'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('time', __('Time') . ':', ['class' => 'control-label']) }}
                                {{ Form::time('time', old('time'), ['required', 'class' => 'form-control', 'placeholder' => __('Select Time') . '...']) }}
                                <span class="help-block">{{ $errors->first('time') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('amount')? 'has-error' : '' }}">
                                @if($errors->has('amount'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('amount', __('Amount') . ':', ['class' => 'control-label']) }}
                                {{ Form::number('amount', old('amount'), ['required', 'class' => 'form-control', 'placeholder' => __('Enter Amount') . '...']) }}
                                <span class="help-block">{{ $errors->first('amount') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('notes')? 'has-error' : '' }}">
                                @if($errors->has('notes'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('notes', __('Notes') . ':', ['class' => 'control-label']) }}
                                {{ Form::textarea('notes', old('notes'), ['class' => 'form-control', 'placeholder' => __('Enter Notes') . '...']) }}
                                <span class="help-block">{{ $errors->first('notes') }}</span>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            {{ link_to_route('dashboard.customerPayments.index', __('Back'), null, [ 'class' => 'btn btn-default', 'tabindex' => '-1' ]) }}
                            {{ Form::submit(__('Store'), ['class' => 'btn btn-primary pull-right']) }}
                        </div>
                        <!-- /.box-footer -->
                        {{ Form::close() }}
                    </div>
                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('AdminLTE/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2.customer').select2();
            $('.select2.customer').select2('focus');
        });
    </script>
@endsection
