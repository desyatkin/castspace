<?php

Class Images extends Eloquent {

	protected $table = 'images';


	//------------------------------------------------------------------------------
	// Получить список фотографий относящихся к определенной категории и ресурсу
	//------------------------------------------------------------------------------
	public static function photos($id, $category) {
		$images = Images::where('category', '=', $category)
							->where('resource_id', '=', $id)
							->get()
							->toArray();

		return $images;
	}


	//------------------------------------------------------------------------------
	// Удалить старые изображения при редактировании
	//------------------------------------------------------------------------------
	public static function removeOldImage($category, $resource_id, $description = null) {
		$image = Images::where('category', '=', $category)
							->where('resource_id', '=', $resource_id)
							->where('description', '=', $description)
							->delete();



		if($image) return true;
		else return false;
	}

}