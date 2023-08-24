@extends('layouts.layout-global')

@section('global_layout')
    @include('components.auth-form', [
        'status' => 'register',
        'action' => route('register'),
        'note' => 'Sudah punya akun?',
        'act' => 'login',
    ])
@endsection
