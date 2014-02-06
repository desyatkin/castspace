<?php $navActive = $_SERVER['REQUEST_URI']; ?>

<ul class="list-group">
	{{-- Моя анкета --}}
	<li class="list-group-item">
		<a href="/profiles/me" class="@if($navActive == '/profiles/me') active @endif">
			Моя анкета
		</a>
	</li>


	{{-- Мои проекты --}}
	<li class="list-group-item">
		<a href="/projects/me" class="@if($navActive == '/projects/me') active @endif">
			Мои проекты

		</a>
		<span class="badge">12</span>
	</li>


	{{-- Мои объявления --}}
	<li class="list-group-item">
		<a href="/adverts/me" class="@if($navActive == '/adverts/me') active @endif">
			Мои объявления
		</a>
	</li>


	{{-- Мои события --}}
	<li class="list-group-item">
		<a href="/events/me" class="@if($navActive == '/events/me') active @endif">
			Мои события
		</a>
	</li>


	{{-- Мои сообщения --}}
	<li class="list-group-item">
		<a href="/messages" class="@if($navActive == '/messages') active @endif">
			Мои сообщения
		</a>
	</li>


	{{-- Моё избранное --}}
	<li class="list-group-item">
		<a href="/folders/me" class="@if($navActive == '/folders/me') active @endif">
			Моё избранное
		</a>
	</li>


	{{-- Настройки --}}
	<li class="list-group-item">
		<a href="/settings" class="@if($navActive == '/settings') active @endif">
			Настройки
		</a>
	</li>
</ul>
