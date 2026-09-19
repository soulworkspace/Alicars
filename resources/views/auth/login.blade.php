@extends('layouts.app')

@section('content')
    {{-- استدعاء مكون تسجيل الدخول الذي أنشأناه --}}
    @livewire('auth.login')
@endsection