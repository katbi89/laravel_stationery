@extends('layouts.print')

@section('title', __('View Bill'))

@section('content')
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-pencil"></i> {{ config('app.name') }}, Com.
                    <small class="pull-right">{{ __('Date') }}: {{ date('d/m/Y') }}</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                {{ __('From') }}
                <address>
                    <strong>{{ $bill->supplier->company }}</strong><br>
                    {{ $bill->supplier->address }}<br>
                    {{ __('Phone') }}: {{ $bill->supplier->phone }}<br>
                    {{ __('Mobile') }}: {{ $bill->supplier->mobile }}<br>
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
                <b>{{ __('Bill') }} #{{ str_pad($bill->id, 6, "0", STR_PAD_LEFT ) }}</b><br>
                <br>
                <b>{{ __('Order ID') }}:</b> 4F3S8J<br>
                <b>{{ __('Receive Date') }}:</b> {{ date('d/m/Y', strtotime($bill->date)) }}<br>
                <b>{{ __('Total Cost') }}:</b> {{ $bill->cost }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('Item') }}</th>
                        <th>{{ __('Unit') }}</th>
                        <th>{{ __('Capacity') }}</th>
                        <th>{{ __('Count') }}</th>
                        <th>{{ __('Cost') }}</th>
                        <th>{{ __('Subtotal') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bill->billItems as $billItem)
                        <tr>
                            <td>{{ $billItem->item->name }}</td>
                            <td>{{ $billItem->unit->name }}</td>
                            <td>{{ $billItem->unit->capacity }}</td>
                            <td>{{ $billItem->count }}</td>
                            <td>{{ $billItem->cost }}</td>
                            <td>{{ $billItem->unit->capacity * $billItem->count * $billItem->cost }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
@endsection
