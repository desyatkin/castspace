@extends( 'profiles.main' )

@section( 'profiles_content' )

<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="css/bootstrap-image-gallery.min.css">
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

<div class="row">
	
	{{-- Аватар --}}
	<div class="col-md-5">
		<?php 
			$avatar = Profiles::avatar($user->profile->id); 
		?>

		@if( !empty($avatar['preview']) )
			
			<img src="/{{ $avatar['preview'] }}" width="200" class="">
		@else
			<img src="/images/userPhoto/noImage.jpg" alt="{{ $user->firstname }}" width="100" class="">
		@endif

		<div style="text-align: center; padding-top: 5px;">
			<a href="#" onClick="showMessageForm( {{ $user->id }}, '{{ $user->firstname }}', '{{ $user->lastname }}' ); return false;">
				<i class="glyphicon glyphicon-comment"></i>
				Написать сообщение
			</a>
		</div>

		<div style="padding-top: 5px;">
			@foreach($photos as $photo)
				<a href="/{{ $photo['full'] }}" data-gallery>
					<img src="/{{ $photo['preview'] }}" style="width: 80px; margin: 10px;" class="">
				</a>
			@endforeach
		</div>
	</div>

	<div class="col-md-7">
		<h3>{{ $user->firstname }} {{ $user->lastname }}</h3>

		<table class="table table-striped">
			{{-- Пол --}}
			<tr>
				<td>Пол</td>
				<td>
                    @if( $user->profile->gender == 1) Женский @endif
                    @if( $user->profile->gender == 0) Мужской @endif
                </td>
			</tr>


			{{-- Дата рождения --}}
			<tr>
				<td>Дата рождения</td>
				<td>{{-- $age --}}</td>
			</tr>


			{{-- Страна --}}
			<tr>
				<td>Страна</td>
				<td>{{ $user->profile->country }}</td>
			</tr>


			{{-- Город --}}
			<tr>
				<td>Город</td>
				<td>{{ $user->profile->city }}</td>
			</tr>


			{{-- Категория --}}
			<tr>
				<td>Категория</td>
				<td>{{ $user->profile->category }}</td>
			</tr>


			{{-- Подкатегория --}}
			<tr>
				<td>Подкатегория</td>
				<td>{{ $user->profile->subcategory }}</td>
			</tr>


			{{-- Телефон --}}
			<tr>
				<td>Телефон</td>
				<td>{{ $user->profile->phone }}</td>
			</tr>


			{{-- Цвет глаз --}}
			<tr>
				<td>Цвет глаз</td>
				<td>{{ $user->profile->eye }}</td>
			</tr>


			{{-- Цвет волос --}}
			<tr>
				<td>Цвет волос</td>
				<td>{{ $user->profile->hair }}</td>
			</tr>


			{{-- Телосложение --}}
			<tr>
				<td>Телосложение</td>
				<td>{{ $user->profile->physique }}</td>
			</tr>


			{{-- Размер одежды --}}
			<tr>
				<td>Размеры одежды</td>
				<td>{{ $user->profile->size }}</td>
			</tr>


			{{-- Рост --}}
			<tr>
				<td>Рост</td>
				<td>{{ $user->profile->growth }}</td>
			</tr>


			{{-- Опыт работы --}}
			<tr>
				<td>Опыт работы</td>
				<td>{{ $user->profile->experience }}</td>
			</tr>


			{{-- Стаж --}}
			<tr>
				<td>Стаж</td>
				<td>{{ $user->profile->standing }}</td>
			</tr>



			{{-- Деятельность --}}
			<tr>
				<td>Деятельность</td>
				<td>{{ $user->profile->action }}</td>
			</tr>



			{{-- О себе --}}
			<tr>
				<td>О себе</td>
				<td>{{ $user->profile->about }}</td>
			</tr>



			{{-- Сайт --}}
			<tr>
				<td>Сайт</td>
				<td>{{ $user->profile->site }}</td>
			</tr>

		</table>
	</div>

</div>


<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        Previous
                    </button>
                    <button type="button" class="btn btn-primary next">
                        Next
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@include( 'messages.message_modal' )

@endsection