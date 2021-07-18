@extends('layouts.admin')

@section('title', __('View Item'))

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-list"></i> {{ __('View Item') }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.items.index') }}">{{ __('Items') }}</a></li>
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
                            @isset($item->image)
                                {{ Html::image($item->image, $item->name, array('class' => ' img-responsive')) }}
                            @endisset
                            <h3 class="profile-username text-center">{{ $item->name }}</h3>

                            <p class="text-muted text-center">{{ $item->description }}</p>

                            <a href="{{ route('dashboard.items.edit', $item->id) }}" class="btn btn-primary btn-block">
                                <b>
                                    <i class="fa fa-pencil-square-o"></i> {{ __('Edit Item') }}
                                </b>
                            </a>

                            <table id="data_table" align="center" class="table table-borderless table-hover list-group">
                                <thead>
                                <tr>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Count') }}</th>
                                    <th>{{ __('Price') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item->units as $unit)
                                    <tr>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $item->amount / $unit->capacity }}</td>
                                        <td>{{ $unit->capacity }}</td>
                                        <td>{{ $unit->price * $unit->capacity }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-file-text-o margin-r-5"></i> {{ __('Notes') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <p>{{ $item->notes }}</p>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __('Item Activities') }}</h3>
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
                                    @php
                                        $eventItem = $event->items()->find($item->id);
                                    @endphp
                                    @if(class_basename($event) == 'Bill')
                                        <!-- timeline item -->
                                            <li>
                                                <i class="fa fa-sign-in bg-green"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i
                                                            class="fa fa-clock-o"></i> {{ date('h:i A', strtotime($event->time)) }}</span>

                                                    <h3 class="timeline-header">
                                                        <a href="{{ route('dashboard.bills.show', $event->id) }}">{{ __('Bill') }}
                                                            :</a>
                                                        #{{ str_pad($event->id, 6, "0", STR_PAD_LEFT ) }}
                                                    </h3>

                                                    <div class="timeline-body">
                                                        <dl class="dl-horizontal">
                                                            <dt>{{ __('Supplier Name') }}:</dt>
                                                            <dd>{{ $event->supplier->company }}</dd>
                                                            <dt>{{ __('Item Count') }}:</dt>
                                                            <dd>{{ $eventItem->billItem->count }} {{ $eventItem->billItem->unit->name }}</dd>
                                                            <dt>{{ __('Cost') }}:</dt>
                                                            <dd>{{ $eventItem->billItem->cost }}</dd>
                                                            <dt>{{ __('Total Cost') }}:</dt>
                                                            <dd>{{ $eventItem->billItem->unit->capacity * $eventItem->billItem->count * $eventItem->billItem->cost }}</dd>
                                                            <dt>{{ __('Notes') }}:</dt>
                                                            <dd>{{ $event->notes }}</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a href="{{ route('dashboard.bills.edit', $event->id) }}"
                                                           class="btn btn-primary btn-xs">{{ __('Edit') }}</a>
                                                        <a href="{{ route('dashboard.bills.print', $event->id) }}"
                                                           target="_blank"
                                                           class="btn btn-warning btn-xs">{{ __('Print') }}</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- END timeline item -->
                                    @else
                                        <!-- timeline item -->
                                            <li>
                                                <i class="fa fa-sign-out bg-red"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i
                                                            class="fa fa-clock-o"></i> {{ date('h:i A', strtotime($event->time)) }}</span>

                                                    <h3 class="timeline-header">
                                                        <a href="{{ route('dashboard.supplierPayments.show', $event->id) }}">{{ __('Order') }}
                                                            :</a>
                                                        #{{ str_pad($event->id, 6, "0", STR_PAD_LEFT ) }}
                                                    </h3>
                                                    <div class="timeline-body">
                                                        <dl class="dl-horizontal">
                                                            <dt>{{ __('Customer Name') }}:</dt>
                                                            <dd>{{ $event->customer->company }}</dd>
                                                            <dt>{{ __('Item Count') }}:</dt>
                                                            <dd>{{ $eventItem->orderItem->count }} {{ $eventItem->orderItem->unit->name }}</dd>
                                                            <dt>{{ __('Cost') }}:</dt>
                                                            <dd>{{ $eventItem->orderItem->cost }}</dd>
                                                            <dt>{{ __('Total Cost') }}:</dt>
                                                            <dd>{{ $eventItem->orderItem->unit->capacity * $eventItem->orderItem->count * $eventItem->orderItem->cost }}</dd>
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
