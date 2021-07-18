@extends('layouts.order')

@section('title', __('Test'))

@section('head')
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/metro/css/metro-all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">


@endsection


@section('content')
<h1 class="text-center">Metro 4</h1>
<h3 class="text-center">The Components Library</h3>
<div data-role="cube"></div>
<ul data-role="treeview">
    <li>
        <input type="checkbox" data-role="checkbox" data-caption="Play video" title="">
        <ul>
            <li><input type="checkbox" data-role="checkbox" data-caption="AVI" title=""></li>
            <li><input type="checkbox" data-role="checkbox" data-caption="MPEG" title=""></li>
            <li><input checked type="checkbox" data-role="checkbox" data-caption="VIDX" title=""></li>
            <li><input type="checkbox" data-role="checkbox" data-caption="MP4" title=""></li>
            <li><input checked type="checkbox" data-role="checkbox" data-caption="XVID" title=""></li>
        </ul>
    </li>
    <li><input type="checkbox" data-role="checkbox" data-caption="Play audio" title=""></li>
    <li>
        <input type="checkbox" data-role="checkbox" data-caption="Subtitles" title="">
        <ul>
            <li><input type="checkbox" data-role="checkbox" data-caption="English" title=""></li>
            <li><input checked type="checkbox" data-role="checkbox" data-caption="Ukrainian" title=""></li>
            <li><input type="checkbox" data-role="checkbox" data-caption="Dutch" title=""></li>
        </ul>
    </li>
</ul>

@endsection

@section('script')
    <script href="{{ asset('AdminLTE/plugins/metro/js/metro.min.js') }}"></script>
@endsection
