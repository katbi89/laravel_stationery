@extends('layouts.print')

@section('title', 'View Payment')

@section('content')
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
    </section>
    <!-- /.content -->
@endsection
