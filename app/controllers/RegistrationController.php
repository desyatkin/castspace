<?php 

class RegistrationController extends BaseController {
	//------------------------------------------------------------------------------
	// Домашний метод, выдает форму для регистрации, если пользователь не в системе
	//------------------------------------------------------------------------------
	public function getIndex() {
		if(Auth::check()) Redirect::home();

		$view = View::make('registration.form')
						->with('navActive', '')
						->with('errors', '')
						->with('values', '');

		return $view;
	}

	//------------------------------------------------------------------------------
	// Обрабатываем форму регистрации по POST запросу
	//------------------------------------------------------------------------------
	public function postIndex() {

		$username  = Input::get('username');
		$firstname = Input::get('firstname');
		$lastname  = Input::get('lastname');
		
		// Проверяем поля на заполенность
		if(empty($username))  $errors['username']  = 'Поле ник обязательно для заполнения';
		if(empty($firstname)) $errors['firstname'] = 'Поле имя обязательно для заполнения';
		if(empty($lastname))  $errors['lastname']  = 'Поле фамилия обязательно для заполнения';
		
		// Проверяем email
		if(!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", Input::get('email'))) 
			$errors['email'] = 'Неправильно заполнено поле email';

		// Проверяем нет ли такого email в базе
		if(User::where('email', '=', Input::get('email'))->count())
			$errors['email'] = 'Пользователь с таким email уже зарегистрирован';

		// Проверяем пароль
		if(mb_strlen(Input::get('password')) < 6) 
			$errors['password'] = 'Поле пароль не может быть меньше 6 символов';

		// Проверяем совпадение пароля и повтора
		if(Input::get('password') != Input::get('passwordRepeat'))
			$errors['passwordRepeat'] = 'Пароли не совпадают';


		// Если есть ошибк отдаем форму на доработку
		if(!empty($errors)) {
			$view = View::make('registration.form')
							->with('navActive', '')
							->with('errors', $errors)
							->with('values', Input::all());

			return $view;
		}

		// Сохраняем пользователя в базу
		$user = new User;
		$user->username = Input::get('username');
		$user->firstname = Input::get('firstname');
		$user->lastname  = Input::get('lastname');
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));
		$user->save();

		// Создаем для пользователя анкету
		$profile = new Profiles;
		$profile->user_id = $user->id;
		$profile->save();

		// Отправляем на почту уведомительное письмо
		//Mail::send('emails.welcome', array(), function($message) {
		//	$message->to(Input::get('email'), Input::get('username'))
		//			->subject('CastSpace.ru Добро пожаловать');
		//});

		$view = View::make('registration.complete')->with('navActive', '');
		return $view;
	}


	//------------------------------------------------------------------------------
	// Восстановление пароля (форма для заполнения)
	//------------------------------------------------------------------------------
	public function getForgotPassword() {
		$view = View::make('registration.forgot_password')->with('navActive', '');

		return $view;
	}


	//------------------------------------------------------------------------------
	// Восстановление пароля (отправка письма)
	//------------------------------------------------------------------------------
	public function postForgotPassword() {
		$credentials = array('email' => Input::get('email'));
    	//$password = Password::remind($credentials);

    	//debug($password); 

    	$view = View::make('registration.forgot_password_complete')->with('navActive', '');
    	return $view;
	}
}