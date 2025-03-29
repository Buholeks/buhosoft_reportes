@extends('layouts.app')
@section('content')
@vite(['resources/css/paginas.css'])
<div class="container">
    <h2 class="mb-4" style="text-align: center;">Registro de Chip</h2>
    <div class="row">
        <div class="col-9">
            <form id="FormChip" method="POST" action="{{ route('guardar.Chip') }}">
                @csrf
                <div class="row">
                    <!-- iccid -->
                    <div class="col-3">
                        <label for="iccid">ICCID:</label>
                        <input class="form-control iccid" type="text" name="iccid" required>
                    </div>
                    <div class="col-2">
                        <!-- numero -->
                        <label for="numero">Número:</label>
                        <input class="form-control" type="text" name="numero" required>
                    </div>
                    <div class="col-3 position-relative">
                        <!-- buscar vendedor -->
                        <label for="">Vendedor</label>
                        <input type="text" id="search" class="form-control" data-search-url="{{ route('buscar-vendedores') }}" data-hidden-input-id="hidden_input" placeholder="Buscar Vendedor...">
                        <input type="hidden" id="hidden_input" name="id_vendedor">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="divtabla col-8 mt-3 px-0" style=" height:400px;">
        <table class="table table-hover">
            <thead>
                <tr>

                    <th>Iccid</th>
                    <th>Numero</th>
                    <th>Vendedor</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Chip as $Chip)
                <td>{{ $Chip->iccid }}</td>
                <td>{{ $Chip->numero }}</td>
                <td>{{ $Chip->vendedores ? $Chip->vendedores->nombre : 'N/A' }}</td>
                <td>{{ $Chip->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection