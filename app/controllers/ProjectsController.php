<?php 

Class ProjectsController extends BaseController {

	//------------------------------------------------------------------------------
	// Константа отвечает за принадлежность категории к определенному
	// разделу(анкеты, проекты и др.). Описываются в таблицу sections
	//------------------------------------------------------------------------------
	const SECTION_ID = '2';


	//------------------------------------------------------------------------------
	// Домашний метод
	//------------------------------------------------------------------------------
	public function getIndex() {
		$projects = Projects::get()->toArray();

		$view = View::make('projects.all')
						->with('navActive', 'projects')
						->with('projects', $projects);

		return $view;
	}



	//------------------------------------------------------------------------------
	// Список моих проектов
	//------------------------------------------------------------------------------
	public function getMe() {
		$projects = Projects::where('user_id', '=', Auth::user()->id)->get()->toArray();

		$view = View::make('projects.me')
						->with('navActive', 'projects')
						->with('projects', $projects);

		return $view;
	}


	//------------------------------------------------------------------------------
	// Добавить проект (выдаем форму если GET)
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
		$project['projectname']    = '';
		$project['country_id']     = '';
		$project['city_id']        = '';
		$project['category_id']    = '';
		$project['subcategory_id'] = '';
		$project['is_company']     = '';
		$project['contact_name']   = '';
		$project['phone']          = '';
		$project['about_project']  = '';
		$project['site']           = '';
		$project['id']             = '';

		$view = View::make('projects.form')
						->with('navActive', 'projects')
						->with('countries', $countries)
						->with('cities', $cities)
						->with('categories', $categories)
						->with('subcategories', $subcategories)
						->with('photo', '')
						->with('project', $project);

		return $view;
	}

	//------------------------------------------------------------------------------
	// Редактирование проекта (выдаем форму если $_GET)
	//------------------------------------------------------------------------------
	public function getEdit($idProject) {

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


		// Получаем данные о проекте
		$project = Projects::where('id', '=', $idProject)->get()->toArray();

		// Получаем изображение проекта

		$photo = Images::photos($project[0]['id'], self::SECTION_ID);
		if(empty($photo)) $photo[0] ='';

		$view = View::make('projects.form')
						->with('navActive', 'projects')
						->with('countries', $countries)
						->with('cities', $cities)
						->with('categories', $categories)
						->with('subcategories', $subcategories)
						->with('photo', $photo[0])
						->with('project', $project[0]);

		return $view;
	}


	//------------------------------------------------------------------------------
	// Сохранение проекта (POST зарос)
	//------------------------------------------------------------------------------
	public function postAdd() {

		// Если это редактирование проекта, получаем объект
		if(Input::has('id')) {
			$project = Projects::find(Input::get('id'));
			if(!$project) return Redirect::to('/404');
		} else {
			$project = new Projects;
		}		

		// Заполняем значения модели
		$project->user_id        = Auth::user()->id;
		$project->projectname    = Input::get('projectname');
		$project->country_id     = Input::get('country');
		$project->city_id        = Input::get('city');
		$project->category_id    = Input::get('category');
		$project->subcategory_id = Input::get('subcategory');
		$project->is_company     = Input::get('isCompany');
		$project->contact_name   = Input::get('contactName');
		$project->about_project  = Input::get('aboutProject');
		$project->site           = Input::get('site');

		$project->save();

		$idProject = $project->id;

		// Загружаем изображение проекта		
		if( !empty($_FILES['photo']['name']) ) {

			// Удаляем старое фото, если оно было
			Images::removeOldImage( self::SECTION_ID, $idProject, 'projectPhoto' );

			// Загружаем новое фото
			$this->uploadImage( 'photo', 'images/userPhoto/', self::SECTION_ID, $idProject, 'projectPhoto' );

		}

		Return Redirect::to('/projects/me');
	}


	//------------------------------------------------------------------------------
	// Удаление проекта
	//------------------------------------------------------------------------------
	public function getDelete($idProject) {
		$project = Projects::find($idProject);
		$project->delete();

		return Redirect::to('/projects/me');
	}


	//------------------------------------------------------------------------------
	// Просмотр проекта
	//------------------------------------------------------------------------------
	public function getView($id) {
		$project = Projects::find($id);

        // user age
        //$age = date('Y', time() - strtotime($user->profile->dob) );


		$view = View::make('projects.view')
						->with('navActive', 'projects')
						->with('project', $project);
                        //->with('age', $age);

		return $view;
	}

	//------------------------------------------------------------------------------
	// Удалить фотографию проекта
	//------------------------------------------------------------------------------
	public function getDeletePhoto($idPhoto, $idProject) {
		$image = Images::find($idPhoto)->delete();

		return  Redirect::to( '/projects/edit/' . $idProject );
	}


}