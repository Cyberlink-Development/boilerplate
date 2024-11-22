@extends('layouts.app')
@section('page_title')
    @if($site_settings && !empty($site_settings->site_name))
        {{ $site_settings->site_name }}
    @else
        Sangam
    @endif
    @yield('page_sub_title')
@endsection
@section('css')
    @yield('sub-css')
    @yield('maintain-styles')
@endsection
@section('head-script')

@endsection
@section('content')
    @include('template.default.common.header')
    @yield('content')
    @include('template.default.common.footer')
@endsection
@section('foot-script')
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    @yield('sub-script')
@endsection