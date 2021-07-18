@extends('layouts.admin')

@section('title', __('View Order'))

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-shopping-cart"></i> {{ __('Order') }}
                <small>#{{ str_pad($order->id, 6, "0", STR_PAD_LEFT ) }}</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.orders.index') }}">{{ __('Orders') }}</a></li>
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
                        <strong>{{ config('app.name') }}, Com.</strong><br>
                        {{ config('app.address') }}<br>
                        {{ __('Phone') }}: {{ config('app.phone') }}<br>
                        {{ __('Email') }}: {{ config('app.email') }}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    {{ __('To') }}
                    <address>
                        <strong>{{ $order->customer->company }}</strong><br>
                        {{ $order->customer->address }}<br>
                        {{ __('Phone') }}: {{ $order->customer->phone }}<br>
                        {{ __('Mobile') }}: {{ $order->customer->mobile }}<br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>{{ __('Order') }} #{{ str_pad($order->id, 6, "0", STR_PAD_LEFT ) }}</b><br>
                    <br>
                    <b>{{ __('Order ID') }}:</b> 4F3S8J<br>
                    <b>{{ __('Receive Date') }}:</b> {{ date('d/m/Y', strtotime($order->date)) }}<br>
                    <b>{{ __('Total Cost') }}:</b> {{ $order->cost }}
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
                        @foreach($order->orderItems as $orderItem)
                            <tr>
                                <td>{{ $orderItem->item->name }}</td>
                                <td>{{ $orderItem->unit->name }}</td>
                                <td>{{ $orderItem->unit->capacity }}</td>
                                <td>{{ $orderItem->count }}</td>
                                <td>{{ $orderItem->cost }}</td>
                                <td>{{ $orderItem->unit->capacity * $orderItem->count * $orderItem->cost }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <a href="{{ route('dashboard.orders.print', $order->id) }}" target="_blank" class="btn btn-default"><i
                            class="fa fa-print"></i> {{ __('Print') }}</a>
                </div>
            </div>
        </section>
        <!-- /.content -->
        <div class="clearfix"></div>
    </div>
    <!-- /.content-wrapper -->
@endsection
