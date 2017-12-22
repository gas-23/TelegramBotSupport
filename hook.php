<?php

require_once "bot.php";
require_once "database.php";

$base = new Database();

$body = file_get_contents('php://input');
$update = json_decode($body, true);

$bot = new Bot(BOT_TOKEN);

$message = $update['message'];
$chat = $message['chat'];
$user = $message['from'];
//$infoBot = $bot->request('getMe');

if($message['text']=='/start'){
	$messageBot='Здравствуйте! Вы обратились в службу поддержки, чем я могу вам помочь?';
	$bot->saveUserProfilePhoto($user['id']);
	$base->addChat($chat, $message['date']);
	$base->addUser($user, $message['date']);
	$bot->sendMessage($chat['id'],$messageBot);
}else{
	$base->addMessage($message);
}

//$bot->logBot($infoBot);
$bot->logBot($update);