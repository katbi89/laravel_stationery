@extends('layouts.admin')

@section('title', __('Create New Bill'))

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
                <i class="fa fa-truck"></i> {{ __('Bill') }}
                <small>{{ __('Create') }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.bills.index') }}">{{ __('Bills') }}</a></li>
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
                            <h3 class="box-title">{{ __('Create New Bill') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        {{ Form::model($bill, ['route' => ['dashboard.bills.store'], 'method' => 'post', 'id' => 'bill', 'autocomplete' => 'off']) }}
                        <div class="box-body">
                            @if(isset($bill->supplier_id))
                                <div class="form-group">
                                    {{ Form::label('supplier_id', __('Supplier') . ':', ['class' => 'control-label']) }}
                                    {{ Form::hidden('supplier_id') }}
                                    <h4>{{ $bill->supplier->company  }}</h4>
                                </div>
                            @else
                                <div class="form-group {{ $errors->has('supplier_id')? 'has-error' : '' }}">
                                    @if($errors->has('supplier_id'))
                                        <i class="fa fa-times-circle-o"></i>
                                    @endif
                                    {{ Form::label('supplier_id', __('Supplier') . ':', ['class' => 'control-label']) }}
                                    {{ Form::select('supplier_id', $suppliers, null, ['required', 'class' => 'form-control select2 supplier', 'placeholder' => __('Select Supplier') . '...' ]) }}
                                    <span class="help-block">{{ $errors->first('supplier_id') }}</span>
                                </div>
                            @endif
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
                            <div class="form-group {{ $errors->has('order_id')? 'has-error' : '' }}">
                                @if($errors->has('order_id'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('order_id', __('Order ID') . ':', ['class' => 'control-label']) }}
                                {{ Form::text('order_id', old('order_id'), ['class' => 'form-control', 'placeholder' => __('Enter Order ID') . '...']) }}
                                <span class="help-block">{{ $errors->first('order_id') }}</span>
                            </div>
                            <table class="table table-hover" id="bill_items">
                                <tr>
                                    <th>{{ __('Item') }}</th>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Capacity') }}</th>
                                    <th>{{ __('Count') }}</th>
                                    <th>{{ __('Cost') }}</th>
                                    <th>{{ __('Total Cost') }}</th>
                                    <th>{{ __('Controls') }}</th>
                                </tr>

                                @if(old('billItems'))

                                    @foreach(old('billItems') as $index => $billItem)
                                        <tr class="bill-item" data-index="{{ $index }}">
                                            <td class="item-id {{ $errors->has('billItems.' . $index . '.item_id')? 'has-error' : '' }}">
                                                {{ Form::select('billItems[' . $index . '][item_id]', array_pluck($items, 'name', 'id'), $billItem['item_id'], ['required', 'placeholder' => __('Select Item') . '...', 'class' => 'form-control select2 items']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('billItems.' . $index . '.item_id') }}</span>
                                            </td>
                                            <td class="unit-id {{ $errors->has('billItems.' . $index . '.unit_id')? 'has-error' : '' }}">
                                                {{ Form::select('billItems[' . $index . '][unit_id]', array_pluck($items->find($billItem['item_id'])->units, 'name', 'id'), $billItem['unit_id'], ['required', 'placeholder' => __('Select Unit') . '...', 'class' => 'form-control select2 units'], $unitsOptions) }}
                                                <span
                                                    class="help-block">{{ $errors->first('billItems.' . $index . '.unit_id') }}</span>
                                            </td>
                                            <td class="capacity {{ $errors->has('billItems.' . $index . '.capacity')? 'has-error' : '' }}">
                                                {{ Form::number('billItems[' . $index . '][capacity]', $billItem['capacity'], ['required', is_numeric($billItem['unit_id']) ? 'readonly' : '', 'class' => 'form-control', 'placeholder' => __('Enter Capacity') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('billItems.' . $index . '.capacity') }}</span>

                                            </td>
                                            <td class="count {{ $errors->has('billItems.' . $index . '.count')? 'has-error' : '' }}">
                                                {{ Form::number('billItems[' . $index . '][count]', $billItem['count'], ['required', 'class' => 'form-control', 'placeholder' => __('Enter Count') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('billItems.' . $index . '.count') }}</span>

                                            </td>
                                            <td class="cost {{ $errors->has('billItems.' . $index . '.cost')? 'has-error' : '' }}">
                                                {{ Form::number('billItems[' . $index . '][cost]', $billItem['cost'], ['required', 'class' => 'form-control', 'placeholder' => __('Enter Cost') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('billItems.' . $index . '.cost') }}</span>
                                            </td>
                                            <td class="total-cost">
                                                {{ $billItem['capacity'] * $billItem['count'] * $billItem['cost'] }}
                                            </td>
                                            <td class="controls">
                                                <a class="btn btn-box-tool toggle-item" data-toggle="tooltip"
                                                   title="{{ __('Enable / Disable') }}" tabindex="-1">
                                                    <i class="fa fa-2x fa-toggle-on"></i>
                                                </a>
                                                <a class="btn btn-box-tool delete-item" data-toggle="tooltip"
                                                   title="{{ __('Disable') }}" tabindex="-1">
                                                    <i class="fa fa-2x fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                            <div class="text-center {{ $errors->has('billItems')? 'has-error' : '' }}">
                                <h4 class="help-block">{{ $errors->first('billItems') }}</h4>
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
                            {{ link_to_route('dashboard.bills.index', __('Back'), null, [ 'class' => 'btn btn-default', 'tabindex' => '-1']) }}
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

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('AdminLTE/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        let items = @json($items);

        function totalCost() {
            var capacity = $(this).parents('.bill-item').find('.capacity input').val();
            var count = $(this).parents('.bill-item').find('.count input').val();
            var cost = $(this).parents('.bill-item').find('.cost input').val();
            $(this).parents('.bill-item').find('.total-cost').html(capacity * count * cost);
        }

        function changeItem(e) {
            $(this).parents('tr').find('.capacity input, .count input, .cost input').val('');

            var item = items.find(x => x.id == e.params.data.id);

            if (item) {
                var units = $(this).parents('tr').find('.select2.units').html($('<option selected value/>').text('{{ __('Select Unit') }}...'));

                item.units.forEach(function (unit) {
                    units.append($('<option value="' + unit.id + '" data-capacity="' + unit.capacity + '" data-item-id="' + item.id + '"/>').text(unit.name));
                });
            }
            else {
                var units = $(this).parents('tr').find('.select2.units').html($('<option selected value/>').text('{{ __('Select Unit') }}...'));
            }
        }

        function changeUnit(e) {

            var item = items.find(x => x.id == $(e.params.data.element).data('item-id'));

            if (item) {

                var unit = item.units.find(x => x.id == e.params.data.id);

                if (unit) {
                    $(this).parents('tr').find('.capacity input').val($(e.params.data.element).data('capacity')).attr('readonly', true);
                }
                else {
                    $(this).parents('tr').find('.capacity input').val('').attr('readonly', false);
                }
            }
            else {
                $(this).parents('tr').find('.capacity input').val('').attr('readonly', false);

            }

            $(this).parents('tr').find('.count input').val('');
            $(this).parents('tr').find('.cost input').val('');
        }

        function toggleBillItem() {
            $(this).parents('.bill-item').find('*').prop('disabled', function (i, v) {
                return !v;
            });
            $(this).find('i').toggleClass('fa-toggle-on fa-toggle-off');
        }

        function deleteBillItem() {
            $(this).parents('.bill-item').remove();
        }

        function addNewItem(items, index) {

            var itemId = $('{{ Form::select('', array_pluck($items, 'name', 'id'), null, ['required', 'placeholder' => __('Select Item') . '...', 'class' => 'form-control select2 items']) }}');
            itemId.attr('name', 'billItems[' + index + '][item_id]');

            var tdItemId = $('<td class="item-id"/>').append(itemId);

            var unitId = $('{{ Form::select('', [], null, ['required', 'placeholder' => __('Select Unit') . '...', 'class' => 'form-control select2 units']) }}');
            unitId.attr('name', 'billItems[' + index + '][unit_id]');

            var tdUnitId = $('<td class="unit-id"/>').append(unitId);

            var capacity = $('{{ Form::number('', null, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Capacity') . '...']) }}');
            capacity.attr('name', 'billItems[' + index + '][capacity]');

            var tdcapacity = $('<td class="capacity"/>').append(capacity);

            var count = $('{{ Form::number('', null, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Cost') . '...']) }}');
            count.attr('name', 'billItems[' + index + '][count]');

            var tdCount = $('<td class="count"/>').append(count);

            var cost = $('{{ Form::number('', null, ['required', 'class' => 'form-control', 'placeholder' => 'Enter Cost...']) }}');
            cost.attr('name', 'billItems[' + index + '][cost]');

            var tdCost = $('<td class="cost"/>').append(cost);

            var tdTotalCost = $('<td class="total-cost"/>');

            var toggleButton = $('<a class="btn btn-box-tool toggle-item" data-toggle="tooltip" title="Enable / Disable" tabindex="-1"/>')
                .append($('<i class="fa fa-2x fa-toggle-on"/>'));

            var deleteButton = $('<a class="btn btn-box-tool delete-item" data-toggle="tooltip" title="Delete" tabindex="-1"/>')
                .append($('<i class="fa fa-2x fa-times"/>'));

            var tdControlsButton = $('<td/>').append(toggleButton).append(deleteButton);

            var billItem = $('<tr class="bill-item" data-index="' + index + '"/>')
                .append(tdItemId).append(tdUnitId)
                .append(tdcapacity).append(tdCount)
                .append(tdCost).append(tdTotalCost).append(tdControlsButton);

            billItem.appendTo('#bill_items');

            return billItem;
        }

        function billItemFocusIn() {
            var newRow = addNewItem(items, $('.bill-item:last-child').data('index') + 1);

            $('.bill-item').unbind('focusin');
            $('.bill-item:last-child').focusin(billItemFocusIn);

            newRow.find('.select2').select2({
                tags: true,
                createTag: function (params) {
                    return {
                        id: params.term,
                        text: params.term
                    }
                }
            });

            newRow.find('.select2.items').on('select2:select', changeItem);

            newRow.find('.select2.units').on('select2:select', changeUnit);

            newRow.find('.capacity input, .count input, .cost input').keyup(totalCost);

            newRow.find('.toggle-item').click(toggleBillItem);

            newRow.find('.delete-item').click(deleteBillItem);

            newRow.tooltip({
                selector: '.controls *'
            });
        }

            $(function () {
            var index = 0;
            if ($('.bill-item:last-child').length > 0) {
                index = $('.bill-item:last-child').data('index') + 1;
            }
            addNewItem(items, index);

            $('.select2.supplier, .bill-item .select2').select2({
                tags: true,
                createTag: function (params) {
                    return {
                        id: params.term,
                        text: params.term
                    }
                }
            });
            $('.select2.supplier').select2('focus');

            $('.bill-item').focusin(billItemFocusIn);

            $('.select2.items').on('select2:select', changeItem);

            $('.select2.units').on('select2:select', changeUnit);

            $('#bill input[type="submit"]').click(function (event) {
                $('.bill-item:last-child').remove();
                $('.bill-item:last-child').focusin(billItemFocusIn);
            });

            $('.toggle-item').click(toggleBillItem);

            $('.delete-item').click(deleteBillItem);

            $('.capacity input, .count input, .cost input').keyup(totalCost);
        });

    </script>
@endsection
