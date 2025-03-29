@extends('layouts.app')

@section('content')
<h2>Editar Sucursal</h2>
<form action="{{ route('sucursales.update', $sucursal) }}" method="POST">
    @csrf @method('PUT')
    @include('sucursales._form')
    <button type="submit" class="btn btn-success">Actualizar</button>
</form>
@endsection
