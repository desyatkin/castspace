<?php

Class EventsController extends BaseController {

	//------------------------------------------------------------------------------
	// Константа отвечает за принадлежность категории к определенному
	// разделу(анкеты, проекты и др.). Описываются в таблицу sections
	//------------------------------------------------------------------------------
	const SECTION_ID = '3';

	//------------------------------------------------------------------------------
	// Домашний метод, главная страница
	//------------------------------------------------------------------------------
	public function getIndex() {

		// Получаем все события
		$events = Events::all();

		$view = View::make('events.all')
						->with('events', $events)
						->with('navActive', 'events');

		return $view;
	}

	//------------------------------------------------------------------------------
	// Добавить новое событие, выдаем форму (если $_GET)
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


		// биндим переменные используемые при редактировании
		$event['id']             = '';
		$event['eventname']      = '';
		$event['country_id']     = '';
		$event['city_id']        = '';
		$event['category_id']    = '';
		$event['subcategory_id'] = '';
		$event['eventdate']     = '';
		$event['contact_phone']  = '';
		$event['contact_email']  = '';
		$event['about_event']    = '';
		$event['site']           = '';
	

		$view = View::make('events.form')
						->with('event', $event)
						->with('countries', $countries)
						->with('cities', $cities)
						->with('categories', $categories)
						->with('subcategories', $subcategories)
						->with('photos', array())
						->with('navActive', 'events');

		return $view;
	}


	//------------------------------------------------------------------------------
	// Сохранение события (POST запрос)
	//------------------------------------------------------------------------------
	public function postAdd() {

		// Если это редактирование получаем объект
		if(Input::has('id')) {
			$event = Events::find(Input::get('id'));
			if(!$event) return Redirect::to('/404');
		}
		else {
			$event = new Events;
		}

		//debug(Input::all()); exit;

		$event->eventname      = Input::get('eventname');
		$event->user_id	       = Auth::user()->id;
		$event->country_id     = Input::get('country');
		$event->city_id        = Input::get('city');
		$event->category_id    = Input::get('category');
		$event->subcategory_id = Input::get('subcategory');
		$event->eventdate      = Input::get('eventdate');
		$event->contact_phone  = Input::get('contactPhone');
		$event->contact_email  = Input::get('contactEmail');
		$event->about_event    = Input::get('aboutEvent');
		$event->site           = Input::get('site');

		$event->save();

		// Обрабатываем поля с картинками
		for($i = 1; $i <= 5; ++$i) {
			// Удаляем старое фото, если оно было
			if( !empty($_FILES['photo'.$i]['name']) ) {
				Images::removeOldImage(self::SECTION_ID, $event->id, 'eventPhoto' . $i);
			}

			// Загружаем новое фото
			$this->uploadImage( 'photo'.$i, 'images/userPhoto/', self::SECTION_ID, $event->id, 'eventPhoto'.$i );
		}

		return Redirect::to('/events/me');
	}

	//------------------------------------------------------------------------------
	// Выдает список событий добавленных полльзователем
	//------------------------------------------------------------------------------
	public function getMe() {
		$events = Events::where('user_id', '=', Auth::user()->id)->get()->toArray();

		$view = View::make('events.me')
						->with('navActive', 'events')
						->with('events', $events);

		return $view;
	}


	//------------------------------------------------------------------------------
	// Редактирование события
	//------------------------------------------------------------------------------
	public function getEdit($idEvent) {
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

		// Получаем данные о событии
		$event = Events::where('id', '=', $idEvent)->get()->toArray();

		// получаем загруженные фотографии
		$photos = Images::photos($event[0]['id'], self::SECTION_ID);

		// Формируем вид
		$view = View::make('events.form')
						->with('navActive', 'events')
						->with('countries', $countries)
						->with('cities', $cities)
						->with('categories', $categories)
						->with('subcategories', $subcategories)
						->with('photos', $photos)
						->with('event', $event[0]);

		return $view;
	}


	//------------------------------------------------------------------------------
	// Удаление события
	//------------------------------------------------------------------------------
	public function getDelete($idEvent) {
		$event = Events::find($idEvent);
		$event->delete();

		return Redirect::to('/events/me');
	}


	//------------------------------------------------------------------------------
	// Удаление изображения события
	//------------------------------------------------------------------------------
	public function getDeletePhoto($idPhoto, $idEvent) {
		$image = Images::find($idPhoto)->delete();

		return  Redirect::to( '/events/edit/' . $idEvent );
	}

}