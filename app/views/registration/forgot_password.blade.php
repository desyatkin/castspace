@extends('layouts.main')

@section('content')

<div class="page-header">
	<h1>
		Восстановление пароля<br>
		<small>
			Пожалуйста введите Ваш E-mail, который вы использовали при регистрации. 
			На Ваш почтовый ящик будет отправлено письмо с новым паролем.
			Новый пароль Вы сможете изменить на удобный Вам после входа на сайт в разделе "Настройки".
		</small>
	</h1>
</div>

<form class="form-inline" role="form" method="POST">
	<div class="form-group">
		<label for="email" class="sr-only">Email указанный при регистрации</label>
		<input type="text" name="email" id="email" class="form-control input-lg" placeholder="email">
	</div>
	<button type="submit" class="btn btn-primary input-lg">Выслать пароль</button>
</form>

@endsection