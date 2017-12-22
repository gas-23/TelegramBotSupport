<?php 
require_once "database.php";
$base = new Database();


switch ($_GET['func']) {
	case 'getChatList':
		return $base->getChatList();
		break;
	case 'getChatMessage':
		return $base->getChatMessage();
		break;
	case 'addFavorite':
		$base->addFavorite();
		break;
	case 'removeFavorite':
		$base->removeFavorite();
		break;
	case 'sendMessageBot':
		require_once "bot.php";
		$bot = new Bot(BOT_TOKEN);

		$messageBot = array(
			'user_id'=>BOT_ID,
			'chat_id'=>$_POST['chat_id'],
			'text'=>$_POST['text']
		);

		$bot->sendMessage($messageBot['chat_id'],$messageBot['text']);
		$base->addMessageBot($messageBot);
		break;
}

?>