@extends( 'profiles.main' )

@section( 'profiles_content' )

@foreach($users as $user)

	<div class="row">

	{{-- Аватар --}}
	<div class="col-md-3">
		<?php 
			$avatar = Profiles::avatar($user->profile->id); 
		?>

		@if( !empty($avatar['preview']) )
			
			<img src="/{{ $avatar['preview'] }}" width="100" class="img-circle">
		@else
			<img src="/images/userPhoto/noImage.jpg" alt="{{ $user->firstname }}" width="100" class="img-circle">
		@endif
	</div>


	{{-- Название проекта --}}
	<div class="col-md-8">
		<h3>
			<a href="profiles/view/{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }}</a>
		</h3>

		{{-- Описание проекта --}}
		<blockquote>
			<p><small>{{ $user->profile->about }}</small></p>
		</blockquote>

	</div>

	</div>

	{{-- Кнопки управления --}}
	<div class="row">
		<div class="col-md-5 col-md-offset-8">
			<a href="#" onClick="showMessageForm( {{ $user->id }}, '{{ $user->firstname }}', '{{ $user->lastname }}' ); return false;">
				<i class="glyphicon glyphicon-comment"></i>
				Написать сообщение
			</a>
		</div>
	</div>

<hr><br>

@endforeach

@include( 'messages.message_modal' )

@endsection