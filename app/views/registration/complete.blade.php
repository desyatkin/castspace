@extends('layouts.main')

@section('content')
<div class="page-header">
	<h1>Регистрация</h1>
</div>

<div class="alert alert-success">
	На указанный Вами адрес электронной почты отправлено письмо с инструкцией по использованию аккаунта.<br><br>

	Если Вам на почту не пришло письмо со ссылкой для активации регистрации, проверьте раздел "Спам" или "Не желательная почта".<br>
</div>
<br><br>
<h3>Авторизация</h3>
<hr>
@include('signin')
<a href="" onclick="signIn();" class="btn btn-primary pull-right" role="button">Войти</a>
@endsection