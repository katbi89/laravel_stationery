@extends('layouts.admin')

@section('title', 'Edit Order')

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
                <i class="fa fa-shopping-cart"></i> {{ __('Order') }}
                <small>{{ __('Edit') }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.orders.index') }}">{{ __('Orders') }}</a></li>
                <li class="active">{{ __('Edit') }}</li>
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
                            <h3 class="box-title">{{ __('Edit Order') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        {{ Form::model($order, ['route' => ['dashboard.orders.update', $order->id], 'method' => 'put', 'id' => 'order']) }}
                        {{ Form::hidden('id') }}
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('customer_id')? 'has-error' : '' }}">
                                @if($errors->has('customer_id'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('customer_id', __('Customer') . ':', ['class' => 'control-label']) }}
                                {{ Form::select('customer_id', $customers, null, ['required', 'class' => 'form-control select2 customer', 'placeholder' => __('Select Customer') . '...' ]) }}
                                <span class="help-block">{{ $errors->first('customer_id') }}</span>
                            </div>
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
                            <table class="table table-hover" id="order_items">
                                <tr>
                                    <th>{{ __('Item') }}</th>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Capacity') }}</th>
                                    <th>{{ __('Count') }}</th>
                                    <th>{{ __('Cost') }}</th>
                                    <th>{{ __('Total Cost') }}</th>
                                    <th>{{ __('Controls') }}</th>
                                </tr>

                                @if(old('orderItems'))
                                    @foreach(old('orderItems') as $index => $orderItem)
                                        <tr class="order-item" data-index="{{ $index }}">
                                            <td class="item-id {{ $errors->has('orderItems.' . $index . '.item_id')? 'has-error' : '' }}">
                                                {{ Form::select('orderItems[' . $index . '][item_id]', array_pluck($items, 'name', 'id'), $orderItem['item_id'], ['required', 'placeholder' => __('Select Item') . '...', 'class' => 'form-control select2 items']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.item_id') }}</span>
                                            </td>
                                            <td class="unit-id {{ $errors->has('orderItems.' . $index . '.unit_id')? 'has-error' : '' }}">
                                                {{ Form::select('orderItems[' . $index . '][unit_id]', array_pluck($items->find($orderItem['item_id'])->units, 'name', 'id'), $orderItem['unit_id'], ['required', 'placeholder' => __('Select Unit') . '...', 'class' => 'form-control select2 units'], $unitsOptions) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.unit_id') }}</span>
                                            </td>
                                            <td class="capacity {{ $errors->has('orderItems.' . $index . '.capacity')? 'has-error' : '' }}">
                                                {{ Form::number('orderItems[' . $index . '][capacity]', $orderItem['capacity'], ['required', is_numeric($orderItem['unit_id']) ? 'readonly' : '', 'class' => 'form-control', 'placeholder' => __('Enter Capacity') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.capacity') }}</span>

                                            </td>
                                            <td class="count {{ $errors->has('orderItems.' . $index . '.count')? 'has-error' : '' }}">
                                                {{ Form::number('orderItems[' . $index . '][count]', $orderItem['count'], ['required', 'class' => 'form-control', 'placeholder' => __('Enter Count') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.count') }}</span>

                                            </td>
                                            <td class="cost {{ $errors->has('orderItems.' . $index . '.cost')? 'has-error' : '' }}">
                                                {{ Form::number('orderItems[' . $index . '][cost]', $orderItem['cost'], ['required', 'class' => 'form-control', 'placeholder' => __('Enter Cost') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.cost') }}</span>
                                            </td>
                                            <td class="total-cost">
                                                {{ $orderItem['capacity'] * $orderItem['count'] * $orderItem['cost'] }}
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
                                @else
                                    @foreach($order->orderItems as $index => $orderItem)
                                        <tr class="order-item" data-index="{{ $index }}">
                                            <td class="item-id {{ $errors->has('orderItems.' . $index . '.item_id')? 'has-error' : '' }}">
                                                {{ Form::select('orderItems[' . $index . '][item_id]', array_pluck($items, 'name', 'id'), $orderItem->item_id, ['required', 'placeholder' => __('Select Item') . '...', 'class' => 'form-control select2 items']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.item_id') }}</span>
                                            </td>
                                            <td class="unit-id {{ $errors->has('orderItems.' . $index . '.unit_id')? 'has-error' : '' }}">
                                                {{ Form::select('orderItems[' . $index . '][unit_id]', array_pluck($items->find($orderItem['item_id'])->units, 'name', 'id'), $orderItem->unit_id, ['required', 'placeholder' => __('Select Unit') . '...', 'class' => 'form-control select2 units'], $unitsOptions) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.unit_id') }}</span>
                                            </td>
                                            <td class="capacity {{ $errors->has('orderItems.' . $index . '.capacity')? 'has-error' : '' }}">
                                                {{ Form::number('orderItems[' . $index . '][capacity]', $orderItem->unit->capacity, ['required', 'readonly', 'class' => 'form-control', 'placeholder' => __('Enter Capacity') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.capacity') }}</span>

                                            </td>
                                            <td class="count {{ $errors->has('orderItems.' . $index . '.count')? 'has-error' : '' }}">
                                                {{ Form::number('orderItems[' . $index . '][count]', $orderItem->count, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Count') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.count') }}</span>

                                            </td>
                                            <td class="cost {{ $errors->has('orderItems.' . $index . '.cost')? 'has-error' : '' }}">
                                                {{ Form::number('orderItems[' . $index . '][cost]', $orderItem->cost, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Cost') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('orderItems.' . $index . '.cost') }}</span>
                                            </td>
                                            <td class="total-cost">
                                                {{ $orderItem->unit->capacity * $orderItem->count * $orderItem->cost }}
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
                            <div class="text-center {{ $errors->has('orderItems')? 'has-error' : '' }}">
                                <h4 class="help-block">{{ $errors->first('orderItems') }}</h4>
                            </div>
                            <div class="form-group {{ $errors->has('notes')? 'has-error' : '' }}">
                                @if($errors->has('notes'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('notes', 'Notes:', ['class' => 'control-label']) }}
                                {{ Form::textarea('notes', old('notes'), ['class' => 'form-control', 'placeholder' => 'Enter notes...']) }}
                                <span class="help-block">{{ $errors->first('notes') }}</span>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            {{ link_to_route('dashboard.orders.index', __('Back'), null, [ 'class' => 'btn btn-default', 'tabindex' => '-1' ]) }}
                            {{ Form::submit('Update', ['class' => 'btn btn-primary pull-right']) }}
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
            var capacity = $(this).parents('.order-item').find('.capacity input').val();
            var count = $(this).parents('.order-item').find('.count input').val();
            var cost = $(this).parents('.order-item').find('.cost input').val();
            $(this).parents('.order-item').find('.total-cost').html(capacity * count * cost);
        }

        function changeItem(e) {
            $(this).parents('tr').find('.capacity input, .count input, .cost input').val('');

            var item = items.find(x => x.id == e.params.data.id);

            if (item) {
                var units = $(this).parents('tr').find('.select2.units').html($('<option selected value/>').text('{{ __('Select Unit') }}...'));

                item.units.forEach(function (unit) {
                    units.append($('<option value="' + unit.id + '" data-capacity="' + unit.capacity + '" data-price="' + unit.price + '" data-item-id="' + item.id + '"/>').text(unit.name));
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
                    $(this).parents('tr').find('.cost input').val($(e.params.data.element).data('price'));

                }
                else {
                    $(this).parents('tr').find('.capacity input').val('').attr('readonly', false);
                    $(this).parents('tr').find('.cost input').val('');
                }
            }
            else {
                $(this).parents('tr').find('.capacity input').val('').attr('readonly', false);
                $(this).parents('tr').find('.cost input').val('');
            }

            $(this).parents('tr').find('.count input').val('');
        }

        function toggleOrderItem() {
            $(this).parents('.order-item').find('*').prop('disabled', function (i, v) {
                return !v;
            });
            $(this).find('i').toggleClass('fa-toggle-on fa-toggle-off');
        }

        function deleteOrderItem() {
            $(this).parents('.order-item').remove();
        }

        function addNewItem(items, index) {

            var itemId = $('{{ Form::select('', array_pluck($items, 'name', 'id'), null, ['required', 'placeholder' => __('Select Item') . '...', 'class' => 'form-control select2 items']) }}');
            itemId.attr('name', 'orderItems[' + index + '][item_id]');

            var tdItemId = $('<td class="item-id"/>').append(itemId);

            var unitId = $('{{ Form::select('', [], null, ['required', 'placeholder' => __('Select Unit') . '...', 'class' => 'form-control select2 units']) }}');
            unitId.attr('name', 'orderItems[' + index + '][unit_id]');

            var tdUnitId = $('<td class="unit-id"/>').append(unitId);

            var capacity = $('{{ Form::number('', null, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Capacity') . '...']) }}');
            capacity.attr('name', 'orderItems[' + index + '][capacity]');

            var tdcapacity = $('<td class="capacity"/>').append(capacity);

            var count = $('{{ Form::number('', null, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Cost') . '...']) }}');
            count.attr('name', 'orderItems[' + index + '][count]');

            var tdCount = $('<td class="count"/>').append(count);

            var cost = $('{{ Form::number('', null, ['required', 'class' => 'form-control', 'placeholder' => 'Enter Cost...']) }}');
            cost.attr('name', 'orderItems[' + index + '][cost]');

            var tdCost = $('<td class="cost"/>').append(cost);

            var tdTotalCost = $('<td class="total-cost"/>');

            var toggleButton = $('<a class="btn btn-box-tool toggle-item" data-toggle="tooltip" title="Enable / Disable" tabindex="-1"/>')
                .append($('<i class="fa fa-2x fa-toggle-on"/>'));

            var deleteButton = $('<a class="btn btn-box-tool delete-item" data-toggle="tooltip" title="Delete" tabindex="-1"/>')
                .append($('<i class="fa fa-2x fa-times"/>'));

            var tdControlsButton = $('<td/>').append(toggleButton).append(deleteButton);

            var orderItem = $('<tr class="order-item" data-index="' + index + '"/>')
                .append(tdItemId).append(tdUnitId)
                .append(tdcapacity).append(tdCount)
                .append(tdCost).append(tdTotalCost).append(tdControlsButton);

            orderItem.appendTo('#order_items');

            return orderItem;
        }

        function orderItemFocusIn() {
            var newRow = addNewItem(items, $('.order-item:last-child').data('index') + 1);

            $('.order-item').unbind('focusin');
            $('.order-item:last-child').focusin(orderItemFocusIn);

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

            newRow.find('.toggle-item').click(toggleOrderItem);

            newRow.find('.delete-item').click(deleteOrderItem);

            newRow.tooltip({
                selector: '.controls *'
            });
        }

        $(function () {
            var index = 0;
            if ($('.order-item:last-child').length > 0) {
                index = $('.order-item:last-child').data('index') + 1;
            }
            addNewItem(items, index);

            $('.select2.customer, .order-item .select2').select2({
                tags: true,
                createTag: function (params) {
                    return {
                        id: params.term,
                        text: params.term
                    }
                }
            });
            $('.select2.customer').select2('focus');

            $('.order-item:last-child').focusin(orderItemFocusIn);

            $('.select2.items').on('select2:select', changeItem);

            $('.select2.units').on('select2:select', changeUnit);

            $('#order input[type="submit"]').click(function (event) {
                $('.order-item:last-child').remove();
                $('.order-item:last-child').focusin(orderItemFocusIn);
            });

            $('.toggle-item').click(toggleOrderItem);

            $('.delete-item').click(deleteOrderItem);

            $('.capacity input, .count input, .cost input').keyup(totalCost);
        });

    </script>
@endsection
