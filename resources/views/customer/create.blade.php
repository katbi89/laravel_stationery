@extends('layouts.admin')

@section('title', __('Create New Customer'))

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-users"></i> {{ __('Customer') }}
                <small>{{ __('Create') }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.customers.index') }}">{{ __('Customers') }}</a></li>
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
                            <h3 class="box-title">{{ __('Create New Customer') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        {{ Form::model($customer, ['route' => ['dashboard.customers.store'], 'method' => 'post', 'autocomplete' => 'off']) }}
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('company')? 'has-error' : '' }}">
                                @if($errors->has('company'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('company', __('Company') . ':', ['class' => 'control-label']) }}
                                {{ Form::text('company', old('company'), ['required', 'class' => 'form-control', 'placeholder' => __('Enter Company Name') . '...']) }}
                                <span class="help-block">{{ $errors->first('company') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('name')? 'has-error' : '' }}">
                                @if($errors->has('name'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('name', __('Name') . ':', ['class' => 'control-label']) }}
                                {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => __('Enter Customer Name') . '...']) }}
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('phone')? 'has-error' : '' }}">
                                @if($errors->has('phone'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('phone', __('Phone') . ':', ['class' => 'control-label']) }}
                                {{ Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => __('Enter Phone Number') . '...']) }}
                                <span class="help-block">{{ $errors->first('phone') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('mobile')? 'has-error' : '' }}">
                                @if($errors->has('mobile'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('mobile', __('Mobile') . ':', ['class' => 'control-label']) }}
                                {{ Form::text('mobile', old('mobile'), ['class' => 'form-control', 'placeholder' => __('Enter Mobile Number') . '...']) }}
                                <span class="help-block">{{ $errors->first('mobile') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('address')? 'has-error' : '' }}">
                                @if($errors->has('address'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('address', __('Address') . ':', ['class' => 'control-label']) }}
                                {{ Form::textarea('address', old('address'), ['class' => 'form-control', 'placeholder' => __('Enter Address') . '...']) }}
                                <span class="help-block">{{ $errors->first('address') }}</span>
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
                            {{ link_to_route('dashboard.customers.index', __('Back'), null, [ 'class' => 'btn btn-default', 'tabindex' => '-1' ]) }}
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
