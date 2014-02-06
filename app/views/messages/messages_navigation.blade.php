<ul class="nav nav-tabs">
	<li @if($messagesNav == 'inbox') class="active" @endif><a href="/messages">Входящие</a></li>
	<li @if($messagesNav == 'outbox') class="active" @endif><a href="/messages/outbox">Отправленные</a></li>
</ul>