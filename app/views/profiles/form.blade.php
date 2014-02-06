@extends('profiles.main')

@section('profiles_content')


{{-- Подключаем datepicker --}}
<script src="/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/datepicker.css">

{{-- include imageAreaSeelct library --}}
<link rel="stylesheet" type="text/css" href="/css/imgareaselect-default.css" />
<script type="text/javascript" src="/js/jquery.imgareaselect.pack.js"></script>


{{-- Form to change user data --}}
<form class="form-horizontal" role="form" method="POST" name="profileForm" enctype="multipart/form-data">

	{{-- Пол --}}
	<div class="form-group">
		<label for="gender" class="col-lg-4 control-label">Пол:</label>
		<div class="col-lg-8">
			<select name="gender" id="gender" class="form-control">
				<option></option>
				<option value="0" @if($profile['gender'] == 0) selected @endif>Мужской</option>
				<option value="1" @if($profile['gender'] == 1) selected @endif>Женский</option>
			</select>
		</div>
	</div>


	{{-- Дата рождения --}}
	<div class="form-group">
		<label for="dob" class="col-lg-4 control-label">Дата рождения:</label>
		<div class="col-lg-8">
			<input type="text" name="dob" id="dob" class="form-control" placeholder="Дата рождения" value="{{ $profile['dob'] }}">
		</div>
	</div>

	{{-- Страна --}}
	<div class="form-group">
		<label for="country" class="col-lg-4 control-label">Страна:</label>
		<div class="col-lg-8">
			<select name="country" id="country" class="form-control" onChange="changeCities(this.value);">
				<option></option>
				@foreach($countries as $country)
					<option value="{{ $country['id'] }}" @if($country['id'] === $profile['country']) selected @endif>
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
					<option value="{{ $city['id'] }}" @if($city['id'] === $profile['city']) selected @endif>
						{{ $city['city'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>


	{{-- Категория --}}
	<div class="form-group">
		<label for="category" class="col-lg-4 control-label">Категория:</label>
		<div class="col-lg-8">
			<select name="category" id="category" class="form-control" onChange="changeSubcategories(this.value);">
				<option></option>
				@foreach($categories as $category)
					<option value="{{ $category['id'] }}" @if($category['id'] === $profile['category']) selected @endif>
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
				<option></option>
				@foreach($subcategories as $subcategory)
					<option value="{{ $subcategory['id'] }}" @if($subcategory['id'] === $profile['subcategory']) selected @endif>
						{{ $subcategory['subcategory'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>


	{{-- Контактный телефон --}}
	<div class="form-group">
		<label for="phone" class="col-lg-4 control-label">Контактный телефон:</label>
		<div class="col-lg-8">
			<input type="text" name="phone" id="phone" class="form-control" value="{{ $profile['phone'] }}">
		</div>
	</div>


	{{-- Цвет глаз --}}
	<div class="form-group">
		<label for="eye" class="col-lg-4 control-label">Цвет глаз:</label>
		<div class="col-lg-8">
			<select name="eye" id="eye" class="form-control">
				<option></option>
				@foreach($eye as $eye_element)
					<option value="{{ $eye_element['id'] }}" @if($eye_element['id'] === $profile['eye']) selected @endif>
						{{ $eye_element['color'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>


	{{-- Цвет волос --}}
	<div class="form-group">
		<label for="hair" class="col-lg-4 control-label">Цвет волос:</label>
		<div class="col-lg-8">
			<select name="hair" id="hair" class="form-control">
				<option></option>
				@foreach($hair as $hair_element)
					<option value="{{ $hair_element['id'] }}" @if($hair_element['id'] === $profile['hair']) selected @endif>
						{{ $hair_element['color'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>	


	{{-- Ваше телосложение --}}
	<div class="form-group">
		<label for="physique" class="col-lg-4 control-label">Ваше телосложение:</label>
		<div class="col-lg-8">
			<select name="physique" id="physique" class="form-control">
				<option></option>
				@foreach($physique as $physique_element)
					<option value="{{ $physique_element['id'] }}" @if($physique_element['id'] === $profile['physique']) selected @endif>
						{{ $physique_element['physique'] }}
					</option>
				@endforeach
			</select>
		</div>
	</div>


	{{-- Размер одежды --}}
	<div class="form-group">
		<label for="size" class="col-lg-4 control-label">Размер одежды:</label>
		<div class="col-lg-8">
			<select name="size" id="size" class="form-control">
				<option></option>
				@foreach($size as $size_element)
				<option value="{{ $size_element['id'] }}" @if($size_element['id'] === $profile['size']) selected @endif>
					{{ $size_element['size'] }}
				</option>
				@endforeach
			</select>
		</div>
	</div>


	{{-- Рост --}}
	<div class="form-group">
		<label for="growth" class="col-lg-4 control-label">Ваш рост:</label>
		<div class="col-lg-8">
			<select name="growth" id="growth" class="form-control">
				<option></option>
				@for($i=10; $i < 250; $i++)
					<option value="{{ $i }}" @if($i == $profile['growth']) selected @endif>
						{{ $i }}
					</option>
				@endfor
			</select>
		</div>
	</div>


	{{-- Опыт работы --}}
	<div class="form-group">
		<label for="experience" class="col-lg-4 control-label">Опыт работы:</label>
		<div class="col-lg-8">
			<input type="text" name="experience" id="experience" placeholder="Опыт работы" class="form-control" value="{{ $profile['experience'] }}">
		</div>
	</div>


	{{-- Общий стаж --}}
	<div class="form-group">
		<label for="standing" class="col-lg-4 control-label">Общий стаж (лет):</label>
		<div class="col-lg-8">
			<select name="standing" id="standing" class="form-control">
				<option></option>
				@for($i = 0; $i < 51; $i++)
					<option value="{{ $i }}" @if($i == $profile['standing']) selected @endif>
						{{ $i }}
					</option>
				@endfor
			</select>
		</div>
	</div>


	{{-- Деятельность --}}
	<div class="form-group">
		<label for="action" class="col-lg-4 control-label">Деятельность:</label>
		<div class="col-lg-8">
			<textarea rows="5" name="action" id="action" class="form-control" placeholder="Максимально подробно расскажите о своем опыте работы.">{{ $profile['action'] }}</textarea>
		</div>
	</div>


	{{-- О себе --}}
	<div class="form-group">
		<label for="about" class="col-lg-4 control-label">О себе:</label>
		<div class="col-lg-8">
			<textarea rows="5" name="about" id="about" class="form-control" placeholder="Расскажите о себе">{{ $profile['about'] }}</textarea>
		</div>
	</div>


	{{-- Фото --}}
	<div class="form-group">
		<label for="photo" class="col-lg-4 control-label">Фото:</label>
		<div class="col-lg-8">

			{{-- Upload photo 1 --}}
			<input type="file" id="photo1" name="photo1" onchange="showCropDialog(this, 1);" class="form-control" style="margin-bottom: 15px;">
			<input type="hidden" name="cropPhoto1_x" value="">
			<input type="hidden" name="cropPhoto1_y" value="">
			<input type="hidden" name="cropPhoto1_width" value="">
			<input type="hidden" name="cropPhoto1_height" value="">


			{{-- Upload photo 2 --}}
			<input type="file" id="photo2" name="photo2" onchange="showCropDialog(this, 2);" class="form-control" style="margin-bottom: 15px;">
			<input type="hidden" name="cropPhoto2_x" value="">
			<input type="hidden" name="cropPhoto2_y" value="">
			<input type="hidden" name="cropPhoto2_width" value="">
			<input type="hidden" name="cropPhoto2_height" value="">


			{{-- Upload photo 3 --}}
			<input type="file" id="photo3" name="photo3" onchange="showCropDialog(this, 3);" class="form-control" style="margin-bottom: 15px;">
			<input type="hidden" name="cropPhoto3_x" value="">
			<input type="hidden" name="cropPhoto3_y" value="">
			<input type="hidden" name="cropPhoto3_width" value="">
			<input type="hidden" name="cropPhoto3_height" value="">


			{{-- Upload photo 4 --}}
			<input type="file" id="photo4" name="photo4" onchange="showCropDialog(this, 4);" class="form-control" style="margin-bottom: 15px;">
			<input type="hidden" name="cropPhoto4_x" value="">
			<input type="hidden" name="cropPhoto4_y" value="">
			<input type="hidden" name="cropPhoto4_width" value="">
			<input type="hidden" name="cropPhoto4_height" value="">


			{{-- Upload photo 5 --}}
			<input type="file" id="photo5" name="photo5" onchange="showCropDialog(this, 5);" class="form-control" style="margin-bottom: 15px;">
			<input type="hidden" name="cropPhoto5_x" value="">
			<input type="hidden" name="cropPhoto5_y" value="">
			<input type="hidden" name="cropPhoto5_width" value="">
			<input type="hidden" name="cropPhoto5_height" value="">
			
		</div>
	</div>


	{{-- Веб сайт --}}
	<div class="form-group">
		<label for="site" class="col-lg-4 control-label">Веб сайт:</label>
		<div class="col-lg-8">
			<input type="text" name="site" id="site" class="form-control" value="{{ $profile['site'] }}">
		</div>
	</div>
	

	{{-- Кнопки управления --}}
	<div class="form-group">
		<div class="col-lg-offset-4 col-lg-8">
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</div>
	</div>



{{-- Form for upload photo --}}
<div class="modal fade" id="modalPhoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Редактирование миниатюры</h4>
      </div>
      <div class="modal-body" style="text-align: center;" id="modalPhotoBody">

      {{-- modal photo content --}}
      <img src="#" id="imageForCrop">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="completeCrop();">Сохранить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



</form>



<script type="text/javascript">
//------------------------------------------------------------------------------
// Подключаем datepicker для поля дата рождения
//------------------------------------------------------------------------------
$('#dob').datepicker({
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


//------------------------------------------------------------------------------
// show modal window with crop dialog
//------------------------------------------------------------------------------
function showCropDialog(input, id) {

	// read image
	if ( input.files && input.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
             $('#imageForCrop').attr( "src", e.target.result )
             $('#imageForCrop').css('max-width', '800px');

             var image = document.getElementById('imageForCrop');

             // Надо сделать поправку на коэфециент сжатия изображения
             // Реальная ширина изображения разделить на ширину в окне клиента
             // все вычисляемые координаты умножать на этот коэфециент с высокой точностью


             window.crop_id = id;

            $('#imageForCrop').imgAreaSelect({

            	aspectRatio: "1:1",
		        onSelectEnd: function (img, selection) {
		            $('input[name="cropPhoto' + window.crop_id +'_x"]').val(selection.x1);
		            $('input[name="cropPhoto' + window.crop_id +'_y"]').val(selection.y1);
		            $('input[name="cropPhoto' + window.crop_id +'_width"]').val(selection.width);
		            $('input[name="cropPhoto' + window.crop_id +'_height"]').val(selection.height);
		        }
		    });
        };       
        FR.readAsDataURL( input.files[0] );
    }

    

    // show modal
	$('#modalPhoto').modal({ keyboard: false }).modal('show');
}


function completeCrop() {
	$('#imageForCrop').imgAreaSelect({ remove: true });
	$('#modalPhoto').modal('hide');
}







</script>

@endsection