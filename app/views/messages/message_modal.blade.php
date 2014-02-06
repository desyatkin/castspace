<div class="modal fade" id="message_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form">
          
          {{-- Тема сообщения --}}
          <div class="form-group">
            <div class="col-lg-12">
              <input type="title" class="form-control" id="title" name="title" placeholder="Тема сообщения">
            </div>
          </div>

          {{-- Сообщение --}}
          <div class="form-group">
            <div class="col-lg-12">
              <textarea class="form-control" id="messageContent" name="messageContent" placeholder="Сообщение" rows="7"></textarea>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-primary" id="messageSendButton">Отправить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
  
//------------------------------------------------------------------------------
// показывает окно для написания нового сообщения
//------------------------------------------------------------------------------
function showMessageForm( userId, firstname, lastname ) {
  $( '#messageSendButton' ).attr( 'onclick', 'sendMessage(' + userId + ')' );
  $( '.modal-title' ).html( 'Новое сообщение для ' + firstname + ' ' + lastname );
  $('#message_modal').modal('show');
}


//------------------------------------------------------------------------------
// Отправка сообщения
//------------------------------------------------------------------------------
function sendMessage( recipientId ) {
  var title   = $( '#title' ).val();
  var messageContent = $( '#messageContent' ).val();

  $.post( '/messages/send', { recipientId: recipientId, title: title, messageContent: messageContent }, function( data ) {
    console.log( data );
    clearMessagesForm();
    $('#message_modal').modal('hide');
  });
}


//------------------------------------------------------------------------------
// Очистка формы сообщений
//------------------------------------------------------------------------------
function clearMessagesForm() {
  $('#title').val('');
  $('#messageContent').val('');
  $('#messageSendButton').removeAttr('onclick');
}
</script>