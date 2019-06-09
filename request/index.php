<?php
	include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';
	$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
	$id = filter_input(INPUT_GET, 'num', FILTER_SANITIZE_NUMBER_INT);
	if($name == "personel"):
		
		$st = $db->prepare('SELECT first_name, second_name, last_name, specialty, picture, description FROM content_staff WHERE id = ?');
		$st->bindParam(1, $id);
		$st->execute();
		$staff = $st->fetch();
?>
<img src="/media/<?php echo $staff[4]?>" style="max-height:500px;max-width:300px;margin-right:5px;float:left">
<p><b><?php echo $staff[1]?> <?php echo $staff[0]?> <?php echo $staff[2]?></b></p>
<p><?php echo $staff[3]?></p>
<?php echo $staff[5]?>
<?php elseif($name === "news"):?>
<?php
		$st = $db->prepare('SELECT title, description, picture, created_at FROM content_news WHERE id = ?');
		$st->bindParam(1, $id);
		$st->execute();
		$news = $st->fetch();
?>
<?php 
	$date_els = explode(" ", $news[3]);
	$date_el = explode("-", $date_els[0]);
?>
<img src="/media/<?php echo $news[2]?>" style="max-height:500px;max-width:300px;margin-right:5px;float:left">
<p><b><?php echo $date_el[2]?> <?php echo get_month_name($date_el[1])?> <?php echo $date_el[0]?></b></p>
<p><b><?php echo $news[0]?></b></p>

<?php echo $news[1]?>
<?php endif;?>