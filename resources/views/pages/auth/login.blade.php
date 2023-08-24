@extends('layouts.layout-global')

@section('global_layout')
    @include('components.auth-form', [
        'status' => 'login',
        'action' => route('login'),
        'note' => 'Belum punya akun?',
        'act' => 'register',
    ])
@endsection
