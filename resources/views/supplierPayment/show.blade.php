@extends('layouts.admin')

@section('title', 'View Supplier Payment')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-credit-card-alt"></i> {{ __('Supplier Payment') }}
                <small>#{{ str_pad($payment->id, 6, "0", STR_PAD_LEFT ) }}</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.supplierPayments.index') }}">{{ __('Supplier Payments') }}</a></li>
                <li class="active">{{ __('View') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-pencil"></i> {{ config('app.name') }}, Com.
                        <small class="pull-right">Date: {{ date('d/m/Y') }}</small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>{{ config('app.name') }}, Com.</strong><br>
                        {{ config('app.address') }}<br>
                        Phone: {{ config('app.phone') }}<br>
                        Email: {{ config('app.email') }}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>{{ $payment->supplier->company }}</strong><br>
                        {{ $payment->supplier->address }}<br>
                        Phone: {{ $payment->supplier->phone }}<br>
                        Mobile: {{ $payment->supplier->mobile }}<br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>{{ __('Payment') }} #{{ str_pad($payment->id, 6, "0", STR_PAD_LEFT ) }}</b><br>
                    <br>
                    <b>{{ __('Amount') }}:</b> {{ $payment->amount }}<br>
                    <b>{{ __('Payment Date') }}:</b> {{ date('d/m/Y', strtotime($payment->date)) }}<br>
                    <b>{{ __('Current Balance') }}:</b> {{ $payment->supplier->balance }}
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <a href="{{ route('dashboard.supplierPayments.print', $payment->id) }}" target="_blank" class="btn btn-default"><i
                            class="fa fa-print"></i> {{ __('Print') }}</a>
                </div>
            </div>
        </section>
        <!-- /.content -->
        <div class="clearfix"></div>
    </div>
    <!-- /.content-wrapper -->
@endsection
