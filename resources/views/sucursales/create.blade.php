@extends('layouts.app')

@section('content')
<h2>Nueva Sucursal</h2>
<form action="{{ route('sucursales.store') }}" method="POST">
    @include('sucursales._form')
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection
