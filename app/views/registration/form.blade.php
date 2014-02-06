@extends('layouts.main')

@section('content')
<div class="page-header">
  <h1>Регистрация <br>
   <small>Все поля обязательны для заполнения. Просим использовать реальные имя и фамилию.</small></h1>
</div><br>

<form class="form form-horizontal" role="form" method="POST">

	{{-- Ник --}}
	<div class="form-group @if(!empty($errors['username'])) has-error @endif">
		<label for="username" class="col-lg-2 control-label">Ник:</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="username" id="username" placeholder="Ваш ник" 
			@if(!empty($values['username'])) value="{{ $values['username'] }}" @endif>
			@if(!empty($errors['username'])) 
				<span class="help-block">{{ $errors['username'] }}</span>
			@endif
		</div>
	</div>


	{{-- Имя --}}
	<div class="form-group @if(!empty($errors['firstname'])) has-error @endif">
		<label for="firstname" class="col-lg-2 control-label">Имя:</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="firstname" id="firstname" placeholder="Ваше имя" 
			@if(!empty($values['firstname']))  value="{{ $values['firstname'] }}" @endif>
			@if(!empty($errors['firstname'])) 
				<span class="help-block">{{ $errors['firstname'] }}</span>
			@endif
		</div>
	</div>


	{{-- Фамилия --}}
	<div class="form-group @if(!empty($errors['lastname'])) has-error @endif">
		<label for="lastname" class="col-lg-2 control-label">Фамилия:</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Ваша фамилия" 
			@if(!empty($values['lastname']))  value="{{ $values['lastname'] }}" @endif>
			@if(!empty($errors['lastname'])) 
				<span class="help-block">{{ $errors['lastname'] }}</span>
			@endif
		</div>
	</div>


	{{-- Email --}}
	<div class="form-group @if(!empty($errors['email'])) has-error @else @endif">
		<label for="email" class="col-lg-2 control-label">Email:</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="email" id="email" placeholder="Ваш email" 
			@if(!empty($values['email']))  value="{{ $values['email'] }}" @endif>
			@if(!empty($errors['email'])) 
				<span class="help-block">{{ $errors['email'] }}</span>
			@endif
		</div>
	</div>


	{{-- Пароль --}}
	<div class="form-group @if(!empty($errors['password'])) has-error @endif">
		<label for="password" class="col-lg-2 control-label">Пароль:</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password" id="password" placeholder="Ваш пароль">
			@if(!empty($errors['password'])) 
				<span class="help-block">{{ $errors['password'] }}</span>
			@endif
		</div>
	</div>

	{{-- Пароль повторно --}}
	<div class="form-group @if(!empty($errors['passwordRepeat'])) has-error @endif">
		<label for="passwordRepeat" class="col-lg-2 control-label">Повторите пароль:</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="passwordRepeat" id="passwordRepeat" placeholder="Повторите ваш пароль">
			@if(!empty($errors['passwordRepeat'])) 
				<span class="help-block">{{ $errors['passwordRepeat'] }}</span>
			@endif
		</div>
	</div>

	<div class="form-group @if(!empty($errors['username'])) has-error @endif">
		<div class="col-lg-offset-2 col-lg-10">
			<a href="/" type="button" class="btn btn-default">Отмена</a>
			<button type="button" class="btn btn-primary" onClick="submit();">Зарегистрироваться</button>
		</div>
	</div>


</form>
@endsection