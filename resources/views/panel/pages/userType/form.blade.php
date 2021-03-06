@extends('panel.layouts.app')

@section('content')
<div class="text-right py-2">
	<a class="btn btn-info" href="/panel/user_type">Lista</a>
</div>

<form action="/panel/user_type/save" method="POST">
	@csrf
	<input type="hidden" name="id" value="@isset($form->id){{$form->id}}@endisset">

	<div class="row">
		<div class="col-8 form-group">
			<label for="name">Tipo</label>
		<input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" value="@isset($form->name){{$form->name}}@endisset">
			<small id="nameHelp" class="form-text text-muted">Nome do tipo</small>
		</div>

		<div class="col-4 form-group">
			<label for="level">Nivel de Permissão</label>
			<input type="number" class="form-control" id="level" name="level" aria-describedby="levelHelp" value="@isset($form->level){{$form->level}}@endisset">
			<small id="levelHelp" class="form-text text-muted">Numero da permissão</small>
		</div>
	</div>

	<button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection