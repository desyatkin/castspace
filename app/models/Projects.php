<?php

Class Projects extends Eloquent {

	protected $table = 'projects';

	//------------------------------------------------------------------------------
	// Страна
	//------------------------------------------------------------------------------
	public function countries() {
		return $this->belongsTo('Countries', 'country_id');
	}

	//------------------------------------------------------------------------------
	// Город	
	//------------------------------------------------------------------------------
	public function city() {
		return $this->belongsTo('Cities', 'city_id');
	}

	//------------------------------------------------------------------------------
	// Категория
	//------------------------------------------------------------------------------
	public function category() {
		return $this->belongsTo('Categories', 'category_id');
	}

	//------------------------------------------------------------------------------
	// Подкатегория
	//------------------------------------------------------------------------------
	public function subcategory() {
		return $this->belongsTo('Subcategories', 'subcategory_id');
	}

}