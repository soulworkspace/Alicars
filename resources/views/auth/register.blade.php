@extends('layouts.app')

@section('content')
    {{-- استدعاء مكون الـ Livewire الذي صممناه --}}
    @livewire('auth.register')
@endsection