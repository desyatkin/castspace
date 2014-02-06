<form class="form-horizontal" role="form" onSubmit="signIn(); return false;">
	<div class="form-group">
		<label for="inputEmail1" class="col-lg-2 control-label">Email</label>
		<div class="col-lg-10">
		  <input type="email" class="form-control" id="email" placeholder="Email">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword1" class="col-lg-2 control-label">Пароль</label>
		<div class="col-lg-10">
		  <input type="password" class="form-control" id="password" placeholder="Пароль">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
		  	{{-- Авторизация с помощью социальных сетей --}}
			<script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
			Также Вы можете войти используя:
			<a href="https://loginza.ru/api/widget?token_url=http://castspace.ru" class="loginza">
			    <img src="http://loginza.ru/img/providers/yandex.png"    alt="Yandex"    title="Yandex">
			    <img src="http://loginza.ru/img/providers/google.png"    alt="Google"    title="Google Accounts">
			    <img src="http://loginza.ru/img/providers/vkontakte.png" alt="Вконтакте" title="Вконтакте">
			    <img src="http://loginza.ru/img/providers/mailru.png"    alt="Mail.ru"   title="Mail.ru">
			    <img src="http://loginza.ru/img/providers/twitter.png"   alt="Twitter"   title="Twitter">
			    <img src="http://loginza.ru/img/providers/loginza.png"   alt="Loginza"   title="Loginza">
			    <img src="http://loginza.ru/img/providers/myopenid.png"  alt="MyOpenID"  title="MyOpenID">
			    <img src="http://loginza.ru/img/providers/openid.png"    alt="OpenID"    title="OpenID">
			    <img src="http://loginza.ru/img/providers/webmoney.png"  alt="WebMoney"  title="WebMoney">
			</a>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<a href="/registration/forgot-password">Забыли пароль?</a>
		</div>
	</div
></form>


<script type="text/javascript">
//------------------------------------------------------------------------------
// Функция выполняет авториацию пользователя
//------------------------------------------------------------------------------
function signin() {
	var email    = $('#email').val();
	var password = $('#password').val();

	if(email == '' || password == '') {
		alert('Оба поля обязательны для заполнения');
		return false;
	}

	$.post('/signin', { email: email, password: password}, function(data) {
		if(data == 'correct') { 
			document.location = '/'; 
		}
		else {
			$('.form-group').addClass('has-error');
		}
	});
}
</script>