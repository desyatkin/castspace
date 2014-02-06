@foreach($adverts as $advert)

<div class="row">

	{{-- Изображение события --}}
	<div class="col-md-3">
		<img src="/images/userPhoto/noImage.jpg" alt="{{ $advert['advertname'] }}" width="100" class="img-circle">		
	</div>


	{{-- Название события --}}
	<div class="col-md-8">
		<h3>{{ $advert['advertname'] }}</h3>

		{{-- Описание события --}}
		<blockquote>
			<p><small>{{ $advert['content'] }}</small></p>
		</blockquote>

	</div>

</div>

{{-- Кнопки управления --}}
<div class="row">
	<div class="col-md-5 col-md-offset-7">
		<a href="/adverts/edit/{{ $advert['id'] }}">
			<i class="glyphicon glyphicon-pencil"></i>
			Редактровать
        </a>
		&nbsp;&nbsp;&nbsp;
		<a href="/adverts/delete/{{ $advert['id'] }}">
			<i class="glyphicon glyphicon-trash"></i>
            Удалить
		</a>
	</div>
</div>

<hr><br>



@endforeach