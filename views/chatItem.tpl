<a href="?chat_id=<?php echo $id; if($favorites != 0) echo '&fav=1';?>" class="list__item <?php if($id == $_GET['chat_id']) echo 'active';?>">
	<img class="item__photo" src="/assets/photo/<?php echo (file_exists('./assets/photo/'.$id.'.jpg')) ? $id : 'nophoto'; ?>.jpg" alt="<?php echo $first_name.' '.$last_name;?>">
	<div class="item__container">
		<div class="item__info">
			<div class="item__login"><?php echo $first_name.' '.$last_name;?> 
				<span class="item__favorite <?php  if($favorites != 0) echo 'active';?>" data-favorite="<?php echo $id;?>"><i class="fa fa-star" aria-hidden="true"></i></span>
				
			</div>
			<div class="item__message"><?php echo $msg = $text ?? 'Присоединился к чату';?></div>
			<span class="item__time"><?php echo prepareDate($date); ?></span>
			<?php  if(($read_msg == 0) && ($id != $_GET['chat_id'])) echo '<span class="item__alarm active"><i class="fa fa-circle" aria-hidden="true"></i></span>';?>
		</div>
	</div>
</a>
