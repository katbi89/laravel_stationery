@extends('layouts.admin')

@section('title', __('Edit Item'))

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-list"></i> {{ __('Item') }}
                <small>{{ __('Edit') }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                </li>
                <li><a href="{{ route('dashboard.items.index') }}">{{ __('Items') }}</a></li>
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
                            <h3 class="box-title">{{ __('Edit Item') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        {{ Form::model($item, ['route' => ['dashboard.items.update' , $item->id], 'method' => 'put', 'files' => true, 'id' => 'item', 'autocomplete' => 'off']) }}
                        {{ Form::hidden('id') }}
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('name')? 'has-error' : '' }}">
                                @if($errors->has('name'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('name', __('Name') . ':', ['class' => 'control-label']) }}
                                {{ Form::text('name', old('name'), ['required', 'class' => 'form-control', 'placeholder' => __('Enter Item Name') . '...']) }}
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('description')? 'has-error' : '' }}">
                                @if($errors->has('description'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('description', __('Description') . ':', ['class' => 'control-label']) }}
                                {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => __('Enter Description') . '...']) }}
                                <span class="help-block">{{ $errors->first('description') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('image')? 'has-error' : '' }}">
                                @if($errors->has('image'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('image', __('Image') .':', ['class' => 'control-label']) }}
                                {{ Form::file('image', old('image'), ['class' => 'form-control']) }}
                                <span class="help-block">{{ $errors->first('image') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('notes')? 'has-error' : '' }}">
                                @if($errors->has('notes'))
                                    <i class="fa fa-times-circle-o"></i>
                                @endif
                                {{ Form::label('notes', __('Notes') . ':', ['class' => 'control-label']) }}
                                {{ Form::textarea('notes', old('notes'), ['class' => 'form-control', 'placeholder' => __('Enter Notes') . '...']) }}
                                <span class="help-block">{{ $errors->first('notes') }}</span>
                            </div>
                            <table class="table table-hover" id="item_units">
                                <tr>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Capacity') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Controls') }}</th>
                                </tr>
                                @if(old('units'))
                                    @foreach(old('units') as $index => $unit)
                                        <tr class="item-unit" data-index="{{ $index }}">

                                            <td class="id {{ $errors->has('units.' . $index . '.name')? 'has-error' : '' }}">
                                                {{ Form::text('units[' . $index . '][name]', $unit['name'], ['required', 'class' => 'form-control', 'placeholder' => __('Enter Unit Name') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('units.' . $index . '.name') }}</span>
                                            </td>
                                            <td class="capacity {{ $errors->has('units.' . $index . '.capacity')? 'has-error' : '' }}">
                                                {{ Form::number('units[' . $index . '][capacity]', $unit['capacity'], ['required', 'class' => 'form-control', 'placeholder' => __('Enter Capacity') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('units.' . $index . '.capacity') }}</span>

                                            </td>
                                            <td class="price {{ $errors->has('units.' . $index . '.price')? 'has-error' : '' }}">
                                                {{ Form::number('units[' . $index . '][price]', $unit['price'], ['required', 'class' => 'form-control', 'placeholder' => __('Enter Price') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('units.' . $index . '.price') }}</span>
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
                                    @foreach($item->units as $index => $unit)
                                        <tr class="item-unit" data-index="{{ $index }}">

                                            <td class="id {{ $errors->has('units.' . $index . '.name')? 'has-error' : '' }}">
                                                {{ Form::text('units[' . $index . '][name]', $unit->name, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Unit Name') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('units.' . $index . '.name') }}</span>
                                            </td>
                                            <td class="capacity {{ $errors->has('units.' . $index . '.capacity')? 'has-error' : '' }}">
                                                {{ Form::number('units[' . $index . '][capacity]', $unit->capacity, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Capacity') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('units.' . $index . '.capacity') }}</span>

                                            </td>
                                            <td class="price {{ $errors->has('units.' . $index . '.price')? 'has-error' : '' }}">
                                                {{ Form::number('units[' . $index . '][price]', $unit->price, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Price') . '...']) }}
                                                <span
                                                    class="help-block">{{ $errors->first('units.' . $index . '.price') }}</span>
                                            </td>
                                            <td>
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
                            <div class="text-center {{ $errors->has('units')? 'has-error' : '' }}">
                                <h4 class="help-block">{{ $errors->first('units') }}</h4>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            {{ link_to_route('dashboard.items.index', __('Back'), null, [ 'class' => 'btn btn-default', 'tabindex' => '-1' ]) }}
                            {{ Form::submit(__('Update'), ['class' => 'btn btn-primary pull-right']) }}
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
    <script>
        function toggleItemUnit() {
            $(this).parents('.item-unit').find('*').prop('disabled', function (i, v) {
                return !v;
            });
            $(this).find('i').toggleClass('fa-toggle-on fa-toggle-off');
        }

        function deleteItemUnit() {
            $(this).parents('.item-unit').remove();
        }

        function addNewItem(index) {

            var name = $('{{ Form::text('', null, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Unit Name') . '...']) }}');
            name.attr('name', 'units[' + index + '][name]');

            var tdName = $('<td class="id"/>').append(name);

            var capacity = $('{{ Form::number('', null, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Capacity') . '...']) }}');
            capacity.attr('name', 'units[' + index + '][capacity]');

            var tdCapacity = $('<td class="capacity"/>').append(capacity);

            var price = $('{{ Form::number('', null, ['required', 'class' => 'form-control', 'placeholder' => __('Enter Price') . '...']) }}');
            price.attr('name', 'units[' + index + '][price]');

            var tdPrice = $('<td class="cost"/>').append(price);

            var toggleButton = $('<a class="btn btn-box-tool toggle-item" data-toggle="tooltip" title="{{ __('Enable / Disable') }}" tabindex="-1"/>')
                .append($('<i class="fa fa-2x fa-toggle-on"/>'));

            var deleteButton = $('<a class="btn btn-box-tool delete-item" data-toggle="tooltip" title="{{ __('Delete') }}" tabindex="-1"/>')
                .append($('<i class="fa fa-2x fa-times"/>'));

            var tdControlsButton = $('<td class="controls"/>').append(toggleButton).append(deleteButton);

            var itemUnit = $('<tr class="item-unit" data-index="' + index + '"/>')
                .append(tdName).append(tdCapacity)
                .append(tdPrice).append(tdControlsButton);

            itemUnit.appendTo('#item_units');

            return itemUnit;
        }

        function unitFocusIn() {
            var index = 0;

            if ($('.item-unit:last-child').length > 0) {
                index = $('.item-unit:last-child').data('index') + 1;
            }

            var newRow = addNewItem(index);

            $('.item-unit').unbind('focusin');
            $('.item-unit:last-child').focusin(unitFocusIn);

            newRow.find('.toggle-item').click(toggleItemUnit);

            newRow.find('.delete-item').click(deleteItemUnit);

            newRow.tooltip({
                selector: '.controls *'
            });
        }

        $(function () {

            $('.item-unit').focusin(unitFocusIn);

            $('.toggle-item').click(toggleItemUnit);

            $('.delete-item').click(deleteItemUnit);

            unitFocusIn();

            $('#item input[type="submit"]').click(function (event) {
                $('.item-unit:last-child').remove();
                $('.item-unit:last-child').focusin(unitFocusIn);
            });
        });

    </script>
@endsection
