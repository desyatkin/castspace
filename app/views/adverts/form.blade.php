@extends('adverts.main')

@section('adverts_content')


<form class="form-horizontal" action="/adverts/add" role="form" method="POST">

	{{-- Скрытое поле с id объявления --}}
	<input type="hidden" name="id" value="{{ $advert['id'] }}">

	{{-- Название объявления --}}
	<div class="form-group">
		<label for="advertname" class="col-lg-4 control-label">Название объявления:</label>
		<div class="col-lg-8">
			<input type="text" class="form-control" id="advertname" name="advertname" placeholder="Название объявлегния" value="{{ $advert['advertname'] }}">
		</div>
	</div>

	
	{{-- Страна --}}
	<div class="form-group">
		<label for="country" class="col-lg-4 control-label">Страна:</label>
		<div class="col-lg-8">
			<select name="country" id="country" class="form-control" onChange="changeCities(this.value);">
				<option></option>
				@foreach($countries as $country)
					<option value="{{ $country['id'] }}" @if($country['id'] === $advert['country_id']) selected @endif>
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
					<option value="{{ $city['id'] }}" @if($city['id'] === $advert['city_id']) selected @endif>
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
					<option value="{{ $category['id'] }}" @if($category['id'] === $advert['category_id']) selected @endif>
						{{ $category['category'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>

	
	{{-- Подкатегория --}}
	<div class="form-group">
		<label for="subcategory" class="col-lg-4 control-label">Подкатегория:</label>
		<div class="col-lg-8">
			<select name="subcategory" id="subcategory" class="form-control">
				<option value=""></option>
				@foreach($subcategories as $subcategory)
					<option value="{{ $subcategory['id'] }}" @if($subcategory['id'] === $advert['subcategory_id']) selected @endif>
						{{ $subcategory['subcategory'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>

	
	{{-- Компания / физ. лицо --}}
	<div class="form-group">
		<label for="" class="col-lg-4 control-label">Компания / Физ. лицо:</label>
		<div class="col-lg-8">
			<select name="isCompany" class="form-control">
				<option value="1">Компания</option>
				<option value="0">Физ. лицо</option>
			</select>
		</div>
	</div>


	{{-- Контактное имя --}}
	<div class="form-group">
		<label for="contactName" class="col-lg-4 control-label">Контактное имя:</label>
		<div class="col-lg-8">
			<input type="text" class="form-control" id="contactName" name="contactName" placeholder="Конактное имя" value="{{ $advert['contact_name'] }}">
		</div>
	</div>


	{{-- Контактный телефон --}}
	<div class="form-group">
		<label for="phone" class="col-lg-4 control-label">Контактный телефон:</label>
		<div class="col-lg-8">
			<input type="text" class="form-control" id="phone" name="phone" placeholder="Контактный телефон" value="{{ $advert['contact_phone'] }}">
		</div>
	</div>

	
	{{-- Контактный email --}}
	<div class="form-group">
		<label for="email" class="col-lg-4 control-label">Контактный email:</label>
		<div class="col-lg-8">
			<input type="text" class="form-control" id="email" name="email" placeholder="Контактный email" value="{{ $advert['contact_email'] }}">
		</div>
	</div>

	
	{{-- Объявление --}}
	<div class="form-group">
		<label for="content" class="col-lg-4 control-label">Объявление:</label>
		<div class="col-lg-8">
			<textarea class="form-control" id="content" name="content" placeholder="Объявление">{{ $advert['content'] }}</textarea>
		</div>
	</div>

	
	{{-- Фото --}}
	<div class="form-group">
		<label for="photo" class="col-lg-4 control-label">Фото:</label>
		<div class="col-lg-8">
			{{-- Показыаем изображение если оно загружено --}}
			@if( !empty($photo['preview']) )
				<img src="/{{ $photo['preview'] }}" width="100" alt="{{ $photo['alt'] }}">
				<a href="/projects/delete-photo/{{ $photo['id'] }}/{{ $project['id'] }}">
					<span class="glyphicon glyphicon-trash"></span>
				</a>				
			@endif
		
			<input type="file" name="photo" class="form-control">
		</div>
	</div>

	
	{{-- Веб сайт --}}
	<div class="form-group">
		<label for="site" class="col-lg-4 control-label">Веб сайт:</label>
		<div class="col-lg-8">
			<input type="text" class="form-control" id="site" name="site" placeholder="Веб сайт" value="{{ $advert['site'] }}">
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
$('#advertdate').datepicker({
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


