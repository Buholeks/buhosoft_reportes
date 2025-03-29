@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Historial de Estados</h4>
    @if ($garantia->historial->count() > 0)
    <ul class="list-group list-group-flush">
        @foreach ($garantia->historial->sortByDesc('created_at') as $item)
        <li class="list-group-item">
            <strong>Fecha:</strong> {{ $item->created_at->format('d/m/Y H:i') }}
            <br>
            <strong>De:</strong> {{ $item->estado_anterior ?? 'N/A' }} → <strong>A:</strong> {{ $item->estado_nuevo }} <br>
            <strong>Responsable:</strong> {{ $item->usuario->name ?? 'Desconocido' }}
        </li>
        @endforeach
    </ul>
    @else
    <p>No hay historial registrado aún.</p>
    @endif

</div>

@endsection