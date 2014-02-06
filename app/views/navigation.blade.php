<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-header">
		<a class="navbar-brand" href="/">CastSpace.ru</a>
	</div>

	<div class="collapse navbar-collapse">
	    <ul class="nav navbar-nav">
		    {{-- Анкеты --}}
			<li @if($navActive == 'profiles') class="active" @endif>
				<a href="/profiles">Анкеты</a>
			</li>

			{{-- Проекты --}}
			<li @if($navActive == 'projects') class="active" @endif>
				<a href="/projects">Проекты</a>
			</li>

			{{-- События --}}
			<li @if($navActive == 'events') class="active" @endif>
				<a href="/events">События</a>
			</li>

			{{-- Объявления --}}
			<li @if($navActive == 'adverts') class="active" @endif>
				<a href="/adverts">Объявления</a>
			</li>
	    </ul>
		<ul class="nav navbar-nav navbar-right">
			@if(!Auth::check())
			<li>
				<a href="#signIn" data-toggle="modal">
					<span class="glyphicon glyphicon-eye-open"></span>
					Вход
				</a>
			</li>

			<li>
				<a href="/registration">
					<span class="glyphicon glyphicon-user"></span>
					Регистрация
				</a>
			</li>	

			@else
			<li>
				<a href="/settings" data-toggle="modal">
					<span class="glyphicon glyphicon-user"></span>
					Здраствуйте, {{ Auth::user()->firstname }}
				</a>
			</li>

			<li></li>

			<li>
				<a href="/logout">
					<span class="glyphicon glyphicon-eye-close"></span>
					Выход
				</a>
			</li>	

			@endif	
	    </ul>
	</div>
</nav>



{{-- Всплывающее окно для входа на сайт --}}
<div class="modal fade" id="signIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Авторизация</h4>
        </div>
        <div class="modal-body">
			@include('signin')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
          <button type="button" class="btn btn-primary" onclick="signin(); return false;">Войти</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->