<?php

class ProfilesController extends BaseController {

	//------------------------------------------------------------------------------
	// This conts is responsable for relation category and section
	//------------------------------------------------------------------------------
	const SECTION_ID = '1';

	//------------------------------------------------------------------------------
	// Determine selected nva
	//------------------------------------------------------------------------------
	public $navActive = 'profiles';

	//------------------------------------------------------------------------------
	// Home method, return main page
	//------------------------------------------------------------------------------
	public function getIndex() {
		$users = User::all();

		$view = View::make('profiles.all')
						->with('navActive', $this->navActive)
						->with('users', $users);

		return $view;
	}


	//------------------------------------------------------------------------------
	// Edit user profile
	//------------------------------------------------------------------------------
	public function getMe() {
		// get list of countries
		$countries = Countries::all()->toArray();

		// get list of cities for first country
		$cities = Cities::where('country_id', '=', $countries[0]['id'])
							->get()
							->toArray();

		// get list of categories
		$categories = Categories::where('section_id', '=', self::SECTION_ID)
									->orWhere('section_id', '=', '0')
									->get()
									->toArray();

		// get list of subcategories
		$subcategories = Subcategories::where('category_id', '=', $categories[0]['id'])
											->get()
											->toArray();

		// get list colors of eyes
		$eye = Eye::all()->toArray();

		// get list colors of hair
		$hair = Hair::all()->toArray();

		// get list of physique
		$physique = Physique::all()->toArray();

		// get list sizes of clothes
		$size = Size::all()->toArray();

		// get user's profile data (if they isset)
		$profile = Profiles::where('user_id', '=', Auth::user()->id)->get()->toArray();

		// if country is choosen get its cities
		if(!empty($profile[0]['country'])) {
			$cities = Cities::where('country_id', '=', $profile[0]['country'])
							->get()
							->toArray();
		}

		// if category is choosen get its subcategories
		if(!empty($profile[0]['category'])) { 
			$subcategories = Subcategories::where('category_id', '=', $profile[0]['category'])
											->get()
											->toArray();
		}

		// format contact phone
		if(!empty($profile[0]['phone'])) {
			if(strlen($profile[0]['phone']) == 7)
				$profile[0]['phone'] = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $profile[0]['phone']);
			elseif(strlen($profile[0]['phone']) == 11)
				$profile[0]['phone'] = preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1 ($2) $3-$4", $profile[0]['phone']);
		}

		// generate view
		$view = View::make('profiles.form')
					->with('navActive', $this->navActive)
					->with('countries', $countries)
					->with('cities', $cities)
					->with('categories', $categories)
					->with('subcategories', $subcategories)
					->with('eye', $eye)
					->with('hair', $hair)
					->with('physique', $physique)
					->with('size', $size)
					->with('profile', $profile[0]);

		return $view;
	}

	//------------------------------------------------------------------------------
	// Save edited profile	
	//------------------------------------------------------------------------------
	public function postMe() {
		// get row  with profile data
		$profile = Profiles::where('user_id', '=', Auth::user()->id)
								->get()->toArray();	

		// work with images
		for($i = 1; $i <= 5; ++$i) {
			// delete old image if it was
			if( !empty($_FILES['photo'.$i]['name']) ) {
				Images::removeOldImage(self::SECTION_ID, $profile[0]['id'], 'profilePhoto' . $i);
			}

			// Загружаем новое фото
			$this->uploadImage( 'photo'.$i, 'images/userPhoto/', 
								self::SECTION_ID, 
								$profile[0]['id'], 
								Input::get('cropPhoto'.$i.'_width'),
								Input::get('cropPhoto'.$i.'_height'),
								Input::get('cropPhoto'.$i.'_x'),
								Input::get('cropPhoto'.$i.'_y'),
								'profilePhoto');
		}

		// work with image
		// if(!empty($_FILES['uploadPhotoField']['name'])) {
		// 	$this->uploadImage( 'uploadPhotoField', 
		// 						'images/userPhoto/', 
		// 						self::SECTION_ID, 
		// 						$profile[0]['id'], 
		// 						Input::get('width_crop'),
		// 						Input::get('height_crop'),
		// 						Input::get('x1'),
		// 						Input::get('y1'));
		// }


		$profile = Profiles::find($profile[0]['id']);


		$profile->gender      = Input::get('gender');
		$profile->dob         = date('Y-m-d H:i:s', strtotime(Input::get('dob')));
		$profile->country     = Input::get('country');
		$profile->city        = Input::get('city');
		$profile->category    = Input::get('category');
		$profile->subcategory = Input::get('subcategory');
		$profile->phone       = preg_replace("/[^0-9]/", '', Input::get('phone'));
		$profile->eye         = Input::get('eye');
		$profile->hair        = Input::get('hair');
		$profile->physique    = Input::get('physique');
		$profile->size        = Input::get('size');
		$profile->growth      = Input::get('growth');
		$profile->experience  = Input::get('experience');
		$profile->standing    = Input::get('standing');
		$profile->action      = Input::get('action');
		$profile->about       = Input::get('about');
		$profile->site        = Input::get('site');
		$profile->save();


		return Redirect::to('/profiles/view/'. Auth::user()->id );
	}


	//------------------------------------------------------------------------------
	// Выдает список городов в стране в формате JSON
	//------------------------------------------------------------------------------
	public function postGetCities() {
		if(!Input::has('idCountry')) return '';

		$cities = Cities::where('country_id', '=', Input::get('idCountry'))
							->get()
							->toJson();

		return $cities;
	}


	//------------------------------------------------------------------------------
	// Выдает список подкатегорий в формате JSON
	//------------------------------------------------------------------------------
	public function postGetSubcategories() {
		if(!Input::has('idCategory')) return '';

		$subcategories = Subcategories::where('category_id', '=', Input::get('idCategory'))
											->get()
											->toJson();

		return $subcategories;
	}


	//------------------------------------------------------------------------------
	// Показыает развернутую анкету
	//------------------------------------------------------------------------------
	public function getView($userId) {
		$user = User::find($userId);

		// Получаем фотографии пользователя
		$photos = Images::photos($user->profile->id, self::SECTION_ID);

		$view = View::make('profiles.view')
						->with('navActive', 'profiles')
						->with('photos', $photos)
						->with('user', $user);

		return $view;
	}


	//------------------------------------------------------------------------------
	// Удаляет фотографии из анкеты
	//------------------------------------------------------------------------------
	public function getDeletePhoto($id) {
		Images::find($id)->delete();

		return Redirect::to('/profiles/me');
	}
	
}