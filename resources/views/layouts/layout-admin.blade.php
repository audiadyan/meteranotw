@extends('layouts.layout-global')

@section('global_layout')
    @include('partials.navbar')
    @include('partials.sidebar')

    @yield('admin_layout')
@endsection
