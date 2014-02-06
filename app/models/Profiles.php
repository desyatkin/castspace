<?php 

Class Profiles extends Eloquent {

	protected $table = 'profiles';

	//------------------------------------------------------------------------------
	// Страна
	//------------------------------------------------------------------------------
	public function countries() {
		return $this->belongsTo('Countries', 'country');
	}

	//------------------------------------------------------------------------------
	// Город	
	//------------------------------------------------------------------------------
	public function city() {
		return $this->belongsTo('Cities', 'city');
	}

	//------------------------------------------------------------------------------
	// Категория
	//------------------------------------------------------------------------------
	public function category() {
		return $this->belongsTo('Categories', 'category');
	}

	//------------------------------------------------------------------------------
	// Подкатегория
	//------------------------------------------------------------------------------
	public function subcategory() {
		return $this->belongsTo('Subcategories', 'subcategory');
	}
	

	//------------------------------------------------------------------------------
	// Аватар
	//------------------------------------------------------------------------------
	public static function avatar($id) {
		$image = Images::where('category', '=', 1)
							->where('resource_id', '=', $id)
							->where('description', '=', 'profilePhoto1')
							->get()
							->toArray();

		if(isset($image[0])) return $image[0];
		else return false;
	}

}