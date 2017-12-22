<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="PHP Developers contest">
	<title>PHP Developers contest</title>
	<link rel="stylesheet" href="/assets/css/normalize.css">
	<link rel="stylesheet" href="/assets/css/font-awesome.css">
	<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
	<div class="container">
		<div class="top">
			<a href="/" class="top__logo">
				<img src="/assets/img/php_elephant.svg" alt="PHP Developers contest">
				<div class="logo-title">
					<span class="logo-title-bold">PHP</span>
					<span class="logo-title-light">Developers contest</span>
				</div> 
			</a>
			<div class="top__message">
				<label class="btn-favorites">
                    <input class="checkbox" type="checkbox" id="btnfav" <?php if($_GET[fav]==1) echo 'checked'; ?> >
                    <span title="Добавить в избранное"><i class="fa fa-star" aria-hidden="true"></i> </span>
                </label>
				<form id="sendmessage" action="javascript:;" method="post">
					<div class="input-group">
						<input id="textanswer" type="text" class="form-control" placeholder="Сообщение..">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
						</span>
				    </div>
			    </form>
			</div>
		</div>
		<div class="chat">
			<div class="chat__list-container">
				<div class="chat__list" id="chat-list">
					<?php
						require_once "database.php";
						$base = new Database();
						$base->getChatList();
					?>
				</div>
			</div>
			<div class="chat__talk-container">
				<div class="chat__talk" id="chat-message" data-chatid="<?php echo $_GET['chat_id']; ?>">
					 <?php if(!$_GET['chat_id']) echo '<div class="talk__empty">Выберите диалог</div>'; $base->getChatMessage(); ?>
				</div>
			</div>
		</div>
	</div>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>
<script src="/assets/js/main.js"></script>
</body>
</html>