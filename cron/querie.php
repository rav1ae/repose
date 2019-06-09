
<?php
set_time_limit (4800);
include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php'; 

$st = $db->prepare("



");
	echo $st->execute()."<br>";
	$res = $st->fetchAll(PDO::FETCH_NUM);
//SHOW COLUMNS FROM prospect
//ALTER TABLE `prospect` CHANGE `region_group` `region_id`;
//TRUNCATE TABLE prospect

//	echo $st->execute();
/*	
	$st->execute();
	$res = $st->fetchAll(PDO::FETCH_NUM);
	for($i = 0; $i < count($res[0]); $i++){
		echo $res[0][$i].'<br>';
	}
	
  */	

?>
<html>
<head>
</head>
<body>
<table>
<?php for($i = 0; $i < count($res); $i++): ?>
	<tr>
		<?php for($j = 0; $j < count($res[$i]); $j++):?>
		<td>
			<?php echo $res[$i][$j] ?>
		</td>
		<?php endfor; ?>
	</tr>
	<?php endfor;?>
</table>
</body>
</html>