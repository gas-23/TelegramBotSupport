<div class="talk__item">
	<img class="talk__photo" src="/assets/photo/<?php echo (file_exists('./assets/photo/'.$id.'.jpg')) ? $id : 'nophoto'; ?>.jpg" alt="<?php echo $first_name.' '.$last_name;?>">
	<div class="talk__text"><?php echo $text; ?></div>
	<div class="talk__date"><?php echo prepareDate($date); ?></div>
</div>