<?php 

Class AdvertsController extends BaseController {

	//------------------------------------------------------------------------------
	// Константа отвечает за принадлежность категории к определенному
	// разделу(анкеты, проекты и др.). Описываются в таблицу sections
	//------------------------------------------------------------------------------
	const SECTION_ID = '4';

	//------------------------------------------------------------------------------
	// домашний метод	
	//------------------------------------------------------------------------------
	public function getIndex() {
		// Полчаем все объявления
		$adverts = Adverts::all();

		$view = View::make('adverts.all')
						->with('adverts', $adverts)
						->with('navActive', 'adverts');

		return $view;
	}

	//------------------------------------------------------------------------------
	// Форма для добавления новых объявлений (GET запрос)
	//------------------------------------------------------------------------------
	public function getAdd() {
		// Получаем список стран
		$countries = Countries::all()->toArray();

		// Получаем список городов первой страны
		$cities = Cities::where('country_id', '=', $countries[0]['id'])
							->get()
							->toArray();

		// Получаем список категорий
		$categories = Categories::where('section_id', '=', self::SECTION_ID)
									->orWhere('section_id', '=', '0')
									->get()
									->toArray();


		// Получаем список подкатегорий
		$subcategories = Subcategories::where('category_id', '=', $categories[0]['id'])
											->get()
											->toArray();

		// Биндим переменные используемые при редактировании
		$advert['id']             = '';
		$advert['advertname']      = '';
		$advert['country_id']     = '';
		$advert['city_id']        = '';
		$advert['category_id']    = '';
		$advert['subcategory_id'] = '';
		$advert['is_company']     = '';
		$advert['contact_name']   = '';
		$advert['contact_email']  = '';
		$advert['contact_phone']  = '';
		$advert['content']        = '';
		$advert['site']           = '';

		$view = View::make('adverts.form')
						->with('advert', $advert)
						->with('countries', $countries)
						->with('cities', $cities)
						->with('categories', $categories)
						->with('subcategories', $subcategories)
						->with('photo', '')
						->with('navActive', 'adverts');

		return $view;

	}


	//------------------------------------------------------------------------------
	// Сохранение объявления (POST запрос)
	//------------------------------------------------------------------------------
	public function postAdd() {
		// Если это редактирование получаем объект
		if(Input::has('id')) {
			$advert = Adverts::find(Input::get('id'));
			if(!$advert) return Redirect::to('/404');
		}
		else {
			$advert = new Adverts;
		}

		$advert->advertname     = Input::get('advertname');
		$advert->user_id        = Auth::user()->id;
		$advert->country_id     = Input::get('country_id');
		$advert->city_id        = Input::get('city_id');
		$advert->category_id    = Input::get('category_id');
		$advert->subcategory_id = Input::get('subcategory_id');
		$advert->is_company     = Input::get('is_company');
		$advert->contact_name   = Input::get('contact_name');
		$advert->contact_email  = Input::get('contact_email');
		$advert->contact_phone  = Input::get('contact_phone');
		$advert->content        = Input::get('content');
		$advert->site           = Input::get('site');

		$advert->save();

		// Загружаем изображение объявления		
		if( !empty($_FILES['photo']['name']) ) {

			// Удаляем старое фото, если оно было
			Images::removeOldImage( self::SECTION_ID, $advert->id, 'advertPhoto' );

			// Загружаем новое фото
			$this->uploadImage( 'photo', 'images/userPhoto/', self::SECTION_ID, $advert->id, 'advertPhoto' );

		}

		return Redirect::to('adverts/me');
	}


	//------------------------------------------------------------------------------
	// Выдает список объявлений добавленных пользователем
	//------------------------------------------------------------------------------
	public function getMe() {
		$adverts = Adverts::where('user_id', '=', Auth::user()->id)->get()->toArray();

		$view = View::make('adverts.me')
						->with('navActive', 'adverts')
						->with('adverts', $adverts);

		return $view;
	}


	//------------------------------------------------------------------------------
	// форма для редактировани объявления	
	//------------------------------------------------------------------------------
	public function getEdit($idAdvert) {
		// Получаем список стран
		$countries = Countries::all()->toArray();

		// Получаем список городов первой страны
		$cities = Cities::where('country_id', '=', $countries[0]['id'])
							->get()
							->toArray();

		// Получаем список категорий
		$categories = Categories::where('section_id', '=', self::SECTION_ID)
									->orWhere('section_id', '=', '0')
									->get()
									->toArray();

		// Получаем список подкатегорий
		$subcategories = Subcategories::where('category_id', '=', $categories[0]['id'])
											->get()
											->toArray();

		// получаем данные о объявлении
		$advert = Adverts::where('id', '=', $idAdvert)->get()->toArray();

		$photo = Images::photos($advert[0]['id'], self::SECTION_ID);
		if(empty($photo)) $photo[0] ='';

		$view = View::make('adverts.form')
						->with('navActive', 'adverts')
						->with('countries', $countries)
						->with('cities', $cities)
						->with('categories', $categories)
						->with('subcategories', $subcategories)
						->with('photo', $photo)
						->with('advert', $advert[0]);

		return $view;
	}


	//------------------------------------------------------------------------------
	// Удаление объявления
	//------------------------------------------------------------------------------
	public function getDelete($idAdvert) {
		$advert = Adverts::find($idAdvert);
		$advert->delete();

		return Redirect::to('/adverts/me');
	}



}