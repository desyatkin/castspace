@extends('messages.main')

@section('messages_content')

@include('messages.messages_navigation')

<br>

@foreach($messages as $message)

	<div class="panel panel-primary">
		<div class="panel-heading">
			{{-- Разные id получателя для входящих и отправленных --}}
			@if($messagesNav == 'inbox')
				<span class="glyphicon glyphicon-comment" title="Ответить" onClick="showMessageForm( {{ $message->sender->id }},  '{{ $message->sender->firstname }}', '{{ $message->sender->lastname }}' );"></span>
			@else
				<span class="glyphicon glyphicon-comment" title="Ответить" onClick="showMessageForm( {{ $message->recipient->id }},  '{{ $message->recipient->firstname }}', '{{ $message->recipient->lastname }}' );"></span>
			@endif

			<big>{{ $message->title }}</big>
			<div class="pull-right">
				<small>
					@if($messagesNav == 'inbox')
						От: {{ $message->sender->firstname }} {{ $message->sender->lastname }}. 
					@else
						Для: {{ $message->recipient->firstname }} {{ $message->recipient->lastname }}.
					@endif

					Получено: {{ $message->created_at }}.
				</small>
			</div>
			
		</div>
		<div class="panel-body">
			{{ $message->message }}
		</div>	
	</div>

@endforeach

@include('messages.message_modal')

@endsection