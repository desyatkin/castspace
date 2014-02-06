@foreach($projects as $project)

<div class="row">

	{{-- Изображение проекта --}}
	<div class="col-md-3">
		{{-- Полчаем фото --}}
		<?php $photo = Images::photos($project['id'] ,2); ?>

		@if( !empty($photo[0]['preview']) )
			<img src="/{{ $photo[0]['preview'] }}" alt="{{ $project['projectname'] }}" width="100" class="img-circle">		
		@else
			<img src="/images/userPhoto/noImage.jpg" alt="{{ $project['projectname'] }}" width="100" class="img-circle">		
		@endif
	</div>


	{{-- Название проекта --}}
	<div class="col-md-8">
		<h3>
			<a href="/projects/view/{{ $project['id'] }}">
				{{ $project['projectname'] }}
			</a>
		</h3>

		{{-- Описание проекта --}}
		<blockquote>
			<p><small>{{ $project['about_project'] }}</small></p>
		</blockquote>

	</div>

</div>

{{-- Кнопки управления --}}
@if(Auth::user()->id == $project['user_id'])
	<div class="row">
		<div class="col-md-5 col-md-offset-7">
			<a href="/projects/edit/{{ $project['id'] }}">
				<i class="glyphicon glyphicon-pencil"></i>
				Редактровать
			</a>
			&nbsp;&nbsp;&nbsp;
			<a href="/projects/delete/{{ $project['id'] }}">
				<i class="glyphicon glyphicon-trash"></i>
				Удалить
			</a>
		</div>
	</div>
@endif

<hr><br>



@endforeach