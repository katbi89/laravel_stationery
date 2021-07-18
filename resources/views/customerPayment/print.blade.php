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
                {{ __('From') }}
                <address>
                    <strong>{{ $payment->customer->company }}</strong><br>
                    {{ $payment->customer->address }}<br>
                    Phone: {{ $payment->customer->phone }}<br>
                    Mobile: {{ $payment->customer->mobile }}<br>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                {{ __('To') }}
                <address>
                    <strong>{{ config('app.name') }}, Com.</strong><br>
                    {{ config('app.address') }}<br>
                    {{ __('Phone') }}: {{ config('app.phone') }}<br>
                    {{ __('Email') }}: {{ config('app.email') }}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>{{ __('Payment') }} #{{ str_pad($payment->id, 6, "0", STR_PAD_LEFT ) }}</b><br>
                <br>
                <b>{{ __('Amount') }}:</b> {{ $payment->amount }}<br>
                <b>{{ __('Payment Date') }}:</b> {{ date('d/m/Y', strtotime($payment->date)) }}<br>
                <b>{{ __('Current Balance') }}:</b> {{ $payment->customer->balance }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
