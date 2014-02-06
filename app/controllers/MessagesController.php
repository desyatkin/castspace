<?php 

class MessagesController extends BaseController {

	//------------------------------------------------------------------------------
	// Домашний метод показывает входящие сообщение
	//------------------------------------------------------------------------------
	public function getIndex() {
		// получаем входящие сообщения
		$messages = Messages::where('recipient_id', '=', Auth::user()->id)->get();

		$view = View::make('messages.messages_list')
						->with('messages', $messages)
						->with('messagesNav', 'inbox')
						->with('navActive', 'messages');

		return $view;
	}


	//------------------------------------------------------------------------------
	// Отправка сообщения AJAX
	//------------------------------------------------------------------------------
	public function postSend() {
		if(!Input::has('recipientId') || !Input::has('title') || !Input::has('messageContent')) {
			echo 'error';
			exit;
		}
		
		$recipientId    = Input::get('recipientId');
		$title          = Input::get('title');
		$messageContent = Input::get('messageContent');
		
		$message               = new Messages;
		$message->recipient_id = $recipientId;
		$message->sender_id    = Auth::user()->id;
		$message->title        = $title;
		$message->message      = $messageContent;
		$message->save();
	}

	//------------------------------------------------------------------------------
	// Показывает исходящие сообщения
	//------------------------------------------------------------------------------
	public function getOutbox() {
		// получаем отправленые сообщения
		$messages = Messages::where('sender_id', '=', Auth::user()->id)->get();

		$view = View::make('messages.messages_list')
						->with('messagesNav', 'outbox')
						->with('navActive', 'messages')
						->with('messages', $messages);

		return $view;
	}

}