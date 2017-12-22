
var autoload = setInterval(function () {
	//console.log('GET_[]');
	var messages = $("#chat-message"),
		chats = $("#chat-list"),
		chat_id = $("#chat-message").data('chatid');
	$.ajax({
		url: "action.php?func=getChatMessage&chat_id="+chat_id,
		success: function(data) {
			if(data) messages.html(data);
		}
	});

	$.ajax({
		url: "action.php?func=getChatList&chat_id="+chat_id,
		success: function(data) {
			chats.html(data);
		}
	});
}, 10000);

$('#sendmessage').submit(function () {
    var messages = $("#chat-message"),
    	text = $('#textanswer').val(),
    	chat_id = $("#chat-message").data('chatid');
    $.ajax({
        type:"POST",
        url: "action.php?func=sendMessageBot",
        data: {'text' : text, 'chat_id' : chat_id},
        success: function(data) {
			document.getElementById("textanswer").value = "";
		    $.ajax({
				url: "action.php?func=getChatMessage&chat_id="+chat_id,
				success: function(data) {
					if(data) messages.html(data);
				}
			});
		}
    });

    
});

$('#btnfav').change(function () {
	var	chat_id = $("#chat-message").data('chatid'),
		fav_id = $('[data-favorite='+chat_id+']');
		if(this.checked) {
			fav_id.show();
		    $.ajax({
		        url: "action.php?func=addFavorite&chat_id="+chat_id
		    });
		}else {
			fav_id.hide();
		    $.ajax({
		        url: "action.php?func=removeFavorite&chat_id="+chat_id
		    });
		}
	}
);