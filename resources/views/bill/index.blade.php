@extends('layouts.admin')

@section('title', __('Bills'))

@section('head')
    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.' . app()->getLocale() . '.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-truck"></i> {{ __('Bills') }}
                <small>{{ __('All Bills') }}</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li class="active">{{ __('Bills') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                                {{ link_to_route('dashboard.bills.create', __('Create New Bill'), null, ['class' => 'btn btn-success']) }}
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="data_table" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('Supplier Name') }}</th>
                                    <th>{{ __('Cost') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Notes') }}</th>
                                    <th>{{ __('Controls') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->supplier->company }}</td>
                                        <td>{{ $bill->cost }}</td>
                                        <td>{{ $bill->date }}</td>
                                        <td>{{ $bill->notes }}</td>
                                        <td>
                                            <a href="{{ route('dashboard.bills.show', $bill->id) }}"
                                               class="btn btn-box-tool" data-toggle="tooltip" title="{{ __('View') }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dashboard.bills.edit', $bill->id) }}"
                                               class="btn btn-box-tool" data-toggle="tooltip" title="{{ __('Edit') }}">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            @if(!$bill->deleted_at)
                                                {{ Form::open(['route' => ['dashboard.bills.destroy', $bill->id], 'method' => 'delete', 'class' => 'inline']) }}
                                                <button type="submit" class="btn btn-box-tool" data-toggle="tooltip"
                                                        title="{{ __('Delete') }}"
                                                        onclick="return confirm(' {{ __('Do you want to delete this Bill') }} ')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                {{ Form::close() }}
                                            @else
                                                {{ Form::open(['route' => ['dashboard.bills.restore', 'id' => $bill->id ], 'method' => 'post', 'class' => 'inline']) }}
                                                <button type="submit" class="btn btn-box-tool" data-toggle="tooltip"
                                                        title="{{ __('Restore') }}"
                                                        onclick="return confirm(' {{ __('Do you want to restore this Bill') }} ')">
                                                    <i class="fa fa-undo"></i>
                                                </button>
                                                {{ Form::close() }}
                                                @can('forceDelete', $bill)
                                                    {{ Form::open(['route' => ['dashboard.bills.forceDelete', 'id' => $bill->id ], 'method' => 'post', 'class' => 'inline']) }}
                                                    <button type="submit" class="btn btn-box-tool" data-toggle="tooltip"
                                                            title="{{ __('Force Delete') }}"
                                                            onclick="return confirm(' {{ __('Do you want to force delete this Bill') }} ')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    {{ Form::close() }}
                                                @endcan
                                            @endif


                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>{{ __('Supplier Name') }}</th>
                                    <th>{{ __('Cost') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Notes') }}</th>
                                    <th>{{ __('Controls') }}</th>
                                </tr>
                                </tfoot>
                            </table>
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

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- page script -->
    <script>
        $(function () {
            $('#data_table').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                "order": [],
                'info': true,
                'autoWidth': false,
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    {"orderable": false}
                ]
            })
        })
    </script>
@endsection
