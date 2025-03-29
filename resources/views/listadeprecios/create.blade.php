{{-- resources/views/listadeprecios/create.blade.php --}}

<form method="POST" action="{{ route('listadeprecios.store') }}">
    @csrf
    @include('listadeprecios._form')
</form>
