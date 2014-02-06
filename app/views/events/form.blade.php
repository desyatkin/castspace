@extends('events.main')

@section('events_content')

{{-- Подключаем datepicker --}}
<script src="/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/datepicker.css">


<form class="form-horizontal" action="/events/add" role="form" method="POST" enctype="multipart/form-data">

	<input type="hidden" name="id" value="{{ $event['id'] }}">

	{{-- Название события --}}
	<div class="form-group">
		<label for="eventname" class="col-lg-4 control-label">Название события:</label>
		<div class="col-lg-8">
			<input type="text" class="form-control" id="eventname" name="eventname" placeholder="Название события" value="{{ $event['eventname'] }}">
		</div>
	</div>

	{{-- Страна --}}
	<div class="form-group">
		<label for="country" class="col-lg-4 control-label">Страна:</label>
		<div class="col-lg-8">
			<select name="country" id="country" class="form-control" onChange="changeCities(this.value);">
				<option></option>
				@foreach($countries as $country)
					<option value="{{ $country['id'] }}" @if($country['id'] === $event['country_id']) selected @endif>
						{{ $country['country'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>


	{{-- Город --}}
	<div class="form-group">
		<label for="city" class="col-lg-4 control-label">Город:</label>
		<div class="col-lg-8">
			<select name="city" id="city" class="form-control">
			<option></option>
				@foreach($cities as $city)
					<option value="{{ $city['id'] }}" @if($city['id'] === $event['city_id']) selected @endif>
						{{ $city['city'] }}
					</option>
				@endforeach
			</select>
			</select>
		</div>
	</div>


	{{-- Категория --}}
	<div class="form-group">
		<label for="category" class="col-lg-4 control-label">Категория:</label>
		<div class="col-lg-8">
			<select name="category" id="category" class="form-control" onChange="changeSubcategories(this.value);">
				<option value=""></option>
				@foreach($categories as $category)
					<option value="{{ $category['id'] }}" @if($category['id'] === $event['category_id']) selected @endif>
						{{ $category['category'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>


	{{-- Подкаегория --}}
	<div class="form-group">
		<label for="subcategory" class="col-lg-4 control-label">Подкатегория:</label>
		<div class="col-lg-8">
			<select name="subcategory" id="subcategory" class="form-control">
				<option value=""></option>
				@foreach($subcategories as $subcategory)
					<option value="{{ $subcategory['id'] }}" @if($subcategory['id'] === $event['subcategory_id']) selected @endif>
						{{ $subcategory['subcategory'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>


	{{-- Дата события --}}
	<div class="form-group">
		<label for="eventdate" class="col-lg-4 control-label">Дата события:</label>
		<div class="col-lg-8">
			<input type="text" name="eventdate" id="eventdate" class="form-control" placeholder="Дата события" value="{{ $event['eventdate'] }}">
		</div>
	</div>


	{{-- Контактный телефон --}}
	<div class="form-group">
		<label for="contactPhone" class="col-lg-4 control-label">Контактный телефон:</label>
		<div class="col-lg-8">
			<input type="text" class="form-control" id="contactPhone" name="contactPhone" placeholder="Контактный телефон" value="{{ $event['contact_phone'] }}">
		</div>
	</div>


	{{-- Контактный email --}}
	<div class="form-group">
		<label for="contactEmail" class="col-lg-4 control-label">Контактный email:</label>
		<div class="col-lg-8">
			<input type="text" class="form-control" id="contactEmail" name="contactEmail" placeholder="Контактный email" value="{{ $event['contact_email'] }}">
		</div>
	</div>


	{{-- О событии --}}
	<div class="form-group">
		<label for="aboutEvent" class="col-lg-4 control-label">О событии:</label>
		<div class="col-lg-8">
			<textarea rows="5" name="aboutEvent" id="aboutEvent" class="form-control" placeholder="О событии">{{ $event['about_event'] }}</textarea>
		</div>
	</div>


	{{-- Фото --}}
	<div class="form-group">
		<label for="photo" class="col-lg-4 control-label">Фото:</label>
		<div class="col-lg-8">
			@for($i = 1; $i <=5; ++$i) 
				{{-- Выводим уже загруженные картинки, возле соотв. полей --}}
				@foreach($photos as $photo)
					@if( $photo['description'] == 'eventPhoto' . $i )
						<img src="/{{ $photo['preview'] }}" width="100" alt="{{ $photo['alt'] }}">
						<a href="/events/delete-photo/{{ $photo['id'] }}/{{ $event['id'] }}">
							<span class="glyphicon glyphicon-trash"></span>
						</a>
					@endif
				@endforeach
				
				<input type="file" id="photo1" name="photo{{ $i }}" class="form-control">

				<br><br>
			@endfor
		</div>
	</div>



	{{-- Веб сайт --}}
	<div class="form-group">
		<label for="site" class="col-lg-4 control-label">Веб сайт:</label>
		<div class="col-lg-8">
			<input type="text" class="form-control" id="site" name="site" placeholder="Веб сайт" value="{{ $event['site'] }}">
		</div>
	</div>


	{{-- Кнопки управления --}}
	<div class="form-group">
		<div class="col-lg-offset-4 col-lg-8">
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</div>
	</div>



</form>




<script type="text/javascript">
//------------------------------------------------------------------------------
// Подключаем datepicker для поля дата рождения
//------------------------------------------------------------------------------
$('#eventdate').datepicker({
    format: 'yyyy-mm-dd'
});



/*
|-------------------------------------------------------------------------------
| Изменяет список с городами
|-------------------------------------------------------------------------------
|
| В зависимости от выбранной страны изменяем выпадающий список с городом. 
| Данные получаем с помощью AJAX, обращаемся к php ф-ции getCities() в 
| контроллере ProfilesController
|
|-------------------------------------------------------------------------------
*/
function changeCities(idCountry) {
	$.post('/profiles/get-cities', { idCountry: idCountry }, function(data) {
		var cities = eval(data);

		$('#city').empty();
		for(i in cities) {
			$('#city').append('<option value="' + cities[i].id + '">' + cities[i].city + '</option>');
		}
	});
}



/*
|-------------------------------------------------------------------------------
| Изменяет список с подкатегориями
|-------------------------------------------------------------------------------
|
| В зависимости от выбранной категории изменяем выпадающий список с 
| подкатегориями. Данные получаем с помощью AJAX, обращаемся к php ф-ции
| getSubcategories() в контроллере ProfilesController
|
|-------------------------------------------------------------------------------
*/
function changeSubcategories(idCategory) {
	$.post('/profiles/get-subcategories', { idCategory: idCategory }, function(data) {
		var subcategories = eval(data);

		$('#subcategory').empty();
		for(i in subcategories) {
			$('#subcategory').append('<option value="' + subcategories[i].id + '">' + subcategories[i].subcategory + '</option>');
		}
	});
}


</script>



@endsection