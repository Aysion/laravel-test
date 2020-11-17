@extends('panel.layouts.app')

@section('content')

<div class="text-right py-2">
	@if (authMenu('panel.user'))
	<a class="btn btn-info" href="/panel/user">Lista</a>
	@endif
</div>

<form action="/panel/user/save" method="POST">
	@csrf
	<input type="hidden" name="id" value="@isset($form->id){{$form->id}}@endisset">

	<div class="row">
		<div class="col-4 form-group">
			<label for="name">Nome</label>
			<input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" value="@isset($form->name){{$form->name}}@endisset" required>
			<small id="nameHelp" class="form-text text-muted">Nome</small>
		</div>
		<div class="col-4 form-group">
			<label for="email">E-mail</label>
			<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="@isset($form->name){{$form->email}}@endisset" required>
			<small id="emailHelp" class="form-text text-muted">E-mail</small>
		</div>

		<div class="col-4 form-group">
			<label for="users_type_id">Tipo de Usuario</label>
			<select name="users_type_id" id="users_type_id" class="form-control" @if (!authMenu('panel.user')) disabled @endif>
				<option value=""></option>
				@foreach ($selectBox['usersType'] as $item)
				<option value="{{$item->id}}" @if(isset($form) && $item->id == $form->users_type_id) selected @endif>{{$item->name}}</option>
				@endforeach
			</select>
		</div>

		<div class="col-6 form-group">
			<label for="password">Senha</label>
			<input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" value="">
			<small id="passwordHelp" class="form-text text-muted">Senha</small>
		</div>

		<div class="col-6 form-group">
			<label for="passwordConf">Confirmar Senha</label>
			<input type="password" class="form-control" id="passwordConf" name="passwordConf" aria-describedby="passwordConfHelp" value="">
			<small id="passwordConfHelp" class="form-text text-muted">Confirmar Senha</small>
		</div>
	</div>

	<button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection