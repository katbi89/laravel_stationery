@extends('layouts.admin')

@section('title', __('View Customer'))

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-shopping-bag"></i> {{ __('View Customer') }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.customers.index') }}">{{ __('Customers') }}</a></li>
                <li class="active">{{ __('View') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-4">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">

                            <h3 class="profile-username text-center">{{ $customer->company }}</h3>

                            <p class="text-muted text-center">{{ $customer->name }}</p>

                            <a href="{{ route('dashboard.customers.edit', $customer->id) }}"
                               class="btn btn-primary btn-block"><b><i
                                        class="fa fa-pencil-square-o"></i> {{ __('Edit Customer') }}</b></a>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>{{ __('Phone') }}</b> <a class="pull-right">{{ $customer->phone }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Mobile') }}</b> <a class="pull-right">{{ $customer->mobile }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Balance') }}</b> <a class="pull-right">{{ $customer->balance }}</a>
                                </li>
                            </ul>

                            <a href="{{ route('dashboard.customers.orders.create', $customer->id) }}"
                               class="btn btn-danger btn-block"><b>{{ __('Add new Order') }}</b></a>
                            <a href="{{ route('dashboard.customers.payments.create', $customer->id) }}"
                               class="btn btn-success btn-block"><b>{{ __('Add new Payment') }}</b></a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __('About') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong><i class="fa fa-map-marker margin-r-5"></i> {{ __('Address') }}:</strong>

                            <p class="text-muted">{{ $customer->address }}</p>

                            <hr>

                            <strong><i class="fa fa-file-text-o margin-r-5"></i> {{ __('Notes') }}:</strong>

                            <p class="text-muted">
                                {{ $customer->notes }}
                            </p>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __('Customer Activities') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="tab-pane" id="timeline">
                                <!-- The timeline -->
                                <ul class="timeline timeline-inverse">
                                @foreach($events as $event)
                                    @if($loop->first || ($event->date != $prevDate))
                                        <!-- timeline time label -->
                                            <li class="time-label">
                                                <span class="bg-blue">
                                                    {{ date('D d/m/Y', strtotime($event->date)) }}
                                                </span>
                                            </li>
                                            <!-- /.timeline-label -->
                                    @endif
                                    @if(class_basename($event) == 'Order')
                                        <!-- timeline item -->
                                            <li>
                                                <i class="fa fa-2x fa-shopping-cart bg-red"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i
                                                            class="fa fa-clock-o"></i> {{ date('h:i A', strtotime($event->time)) }}</span>

                                                    <h3 class="timeline-header">
                                                        <a href="{{ route('dashboard.orders.show', $event->id) }}">{{ __('Order') }}
                                                            :</a>
                                                        #{{ str_pad($event->id, 6, "0", STR_PAD_LEFT ) }}
                                                    </h3>

                                                    <div class="timeline-body">
                                                        <dl>
                                                            <dt>{{ __('Cost') }}:</dt>
                                                            <dd>{{ $event->cost }}</dd>
                                                            <dt>{{ __('Items Count') }}:</dt>
                                                            <dd>{{ $event->items->count() }} {{ __('Item(s)') }}</dd>
                                                            <dt>{{ __('Notes') }}:</dt>
                                                            <dd>{{ $event->notes }}</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a href="{{ route('dashboard.orders.edit', $event->id) }}"
                                                           class="btn btn-primary btn-xs">{{ __('Edit') }}</a>
                                                        <a href="{{ route('dashboard.orders.print', $event->id) }}"
                                                           target="_blank"
                                                           class="btn btn-warning btn-xs">{{ __('Print') }}</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- END timeline item -->
                                    @else
                                        <!-- timeline item -->
                                            <li>
                                                <i class="fa fa-money bg-green"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i
                                                            class="fa fa-clock-o"></i> {{ date('h:i A', strtotime($event->time)) }}</span>

                                                    <h3 class="timeline-header">
                                                        <a href="{{ route('dashboard.customerPayments.show', $event->id) }}">{{ __('Payment') }}
                                                            :</a>
                                                        #{{ str_pad($event->id, 6, "0", STR_PAD_LEFT ) }}
                                                    </h3>
                                                    <div class="timeline-body">
                                                        <dl>
                                                            <dt>{{ __('Amount') }}:</dt>
                                                            <dd>{{ $event->amount }}</dd>
                                                            <dt>{{ __('Notes') }}:</dt>
                                                            <dd>{{ $event->notes }}</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a href="{{ route('dashboard.customerPayments.edit', $event->id) }}"
                                                           class="btn btn-primary btn-xs">{{ __('Edit') }}</a>
                                                        <a href="{{ route('dashboard.customerPayments.print', $event->id) }}"
                                                           target="_blank"
                                                           class="btn btn-warning btn-xs">{{ __('Print') }}</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- END timeline item -->
                                        @endif
                                        @php
                                            $prevDate = $event->date;
                                        @endphp
                                    @endforeach
                                    <li>
                                        <i class="fa fa-clock-o bg-gray"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


