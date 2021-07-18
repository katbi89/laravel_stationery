@extends('layouts.admin')

@section('title', __('Edit Supplier Payment'))

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
                <i class="fa fa-credit-card-alt"></i> {{ __('Supplier Payments') }}
                <small>{{ __('Edit') }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.supplierPayments.index') }}">{{ __('Supplier Payments') }}</a></li>
                <li class="active">{{ __('Edit') }}</li>
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
                            <h3 class="box-title">{{ __('Edit Supplier Payment') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        {{ Form::model($payment, ['route' => ['dashboard.supplierPayments.update', $payment->id], 'method' => 'put', 'autocomplete' => 'off']) }}
                        {{ Form::hidden('id') }}
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('supplier_id')? 'has-error' : '' }}">
                                @if($errors->has('supplier_id'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('supplier_id', __('Supplier') . ':', ['class' => 'control-label']) }}
                                {{ Form::select('supplier_id', $suppliers, null, ['required', $payment->supplier_id? 'readonly':'', 'class' => 'form-control select2 supplier', 'placeholder' => __('Select Supplier') . '...']) }}
                                <span class="help-block">{{ $errors->first('supplier_id') }}</span>
                            </div>
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
                                {{ Form::number('amount', old('amount'), ['required', 'autofocus', 'class' => 'form-control', 'placeholder' => __('Enter Amount') . '...']) }}
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
                            {{ link_to_route('dashboard.supplierPayments.index', __('Back'), null, [ 'class' => 'btn btn-default', 'tabindex' => '-1' ]) }}
                            {{ Form::submit(__('Update'), ['class' => 'btn btn-primary pull-right']) }}
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
            $('.select2.supplier').select2();
            $('.select2.supplier').select2('focus');
        });
    </script>
@endsection
