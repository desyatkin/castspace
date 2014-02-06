<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/*
	|-------------------------------------------------------------------------------
	| Загрузка изображений
	|-------------------------------------------------------------------------------
	|
	| Функция загружает изображение, уменьшает до нужных размеров, создает
	| уменьшенную копию, заносит запись в таблицу изображений.
	|
	|-------------------------------------------------------------------------------
	*/
	protected function uploadImage($fieldName, $destinationPath, $category, $resource_id, $width_crop=0, $height_crop=0, $x=0, $y=0, $description = null, $alt = null) {
		// Создаем объект
		$file = Input::file($fieldName);
		
		// проверяем есть ли изображение
		if( !is_object($file) ) return false;


		// Проверяем тип файла
		$extension       = $file->getClientOriginalExtension();
		if($extension != 'png' && $extension != 'jpg' && $extension != 'jpeg') {
			die('Не верный тип файла. Для загрузки доступны форматы PNG и JPEG');
		}
 
 		// Переносим в папку назначения с новым именем
		$filename        = str_random(30);
		$imagePath       = $destinationPath . $filename . '.' . $extension;
		$previewPath	 = $destinationPath . 'preview_' . $filename . '.' . $extension;
		$upload_success  = Image::make( Input::file($fieldName)->getRealPath() )
										->resize(1000, null, true)
										->save($imagePath);

		// пробуем загрузить файл
		if($upload_success) {

			if( $width_crop != 0 && $height_crop != 0 ) {
				$preview_success = Image::make($imagePath)
										->crop($width_crop, $height_crop, $x, $y)
										->resize(200, 200)
										->save($previewPath);

			} else {
				$preview_success = Image::make($imagePath)
										->resize(200, 200)
										->save($previewPath);
			}

			if(!$preview_success) return false;

			// Добавляем запись в таблицу изображений
			$image              = new Images;
			$image->category    = $category;
			$image->resource_id = $resource_id;
			$image->full        = $imagePath;
			$image->preview     = $previewPath;
			$image->description = $description;
			$image->alt         = $alt;
			$image->save();

			return true;
		}
		else return false;	

	}



}