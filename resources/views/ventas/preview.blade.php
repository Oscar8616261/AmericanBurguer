@extends('layouts.designer1')
@section('content')
@livewire('ticket-venta', ['ventaId' => $ventaId])
@endsection