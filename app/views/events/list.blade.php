@foreach($events as $event)

<div class="row">

	{{-- Изображение события --}}
	<div class="col-md-3">
		{{-- Полчаем фото --}}
		<?php $photo = Images::photos($event['id'] ,3); ?>

		@if( !empty($photo[0]['preview']) )
			<img src="/{{ $photo[0]['preview'] }}" alt="{{ $event['eventname'] }}" width="100" class="img-circle">		
		@else
			<img src="/images/userPhoto/noImage.jpg" alt="{{ $event['eventname'] }}" width="100" class="img-circle">		
		@endif	
	</div>


	{{-- Название события --}}
	<div class="col-md-8">
		<h3>{{ $event['eventname'] }}</h3>

		{{-- Описание события --}}
		<blockquote>
			<p><small>{{ $event['about_event'] }}</small></p>
		</blockquote>

	</div>

</div>

{{-- Кнопки управления --}}
<div class="row">
	<div class="col-md-5 col-md-offset-7">
		<a href="/events/edit/{{ $event['id'] }}">
			<i class="glyphicon glyphicon-pencil"></i>
			Редактровать
		</a>
		&nbsp;&nbsp;&nbsp;
		<a href="/events/delete/{{ $event['id'] }}">
			<i class="glyphicon glyphicon-trash"></i>
			Удалить
		</a>
	</div>
</div>

<hr><br>



@endforeach