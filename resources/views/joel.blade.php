@extends('layouts.app')

@section('content')
<font color="#f00" size="3em">Bem vindo, {{ $name }} {{ $age }}!</font>

<?php if ($records) : ?>
Carregou
<?php else: ?>
Não carregou
<?php endif ?>

<hr>

@if ($records)
Carregou
@else
Não carregou
@endif

@endsection
