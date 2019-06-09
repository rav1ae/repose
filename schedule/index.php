<?php
	include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';
	
	if(isset($_GET['p'])){
		$pageReq = trim(filter_input(INPUT_GET, "p", FILTER_SANITIZE_STRING), '/');
	}
	else{
		$pageReq = 'about';
	}
	$stt = $db->prepare('SELECT content, title, heading, parent_id, id, meta_keywords, meta_desc FROM content_pages WHERE slug = ?');
	$stt->bindParam(1, $pageReq);
	$stt->execute();
	$result = $stt->fetch();
	
	$stt = $db->prepare("SELECT title FROM content_navblock WHERE id = (SELECT block_id FROM content_nav WHERE page_id = (SELECT id from content_pages WHERE slug = ?))");
	$stt->bindParam(1, $pageReq);
	$stt->execute();
	$parent = $stt->fetch();
	
	$stt = $db->prepare('SELECT cn.title, cp.slug FROM content_nav cn, content_pages cp WHERE cn.block_id = (SELECT block_id FROM content_nav WHERE page_id = (SELECT id from content_pages WHERE slug = ?)) AND cp.id = cn.page_id AND cp.is_active = 1');
	$stt->bindParam(1, $pageReq);
	$stt->execute();
	$children = $stt->fetchAll(PDO::FETCH_NUM);
	
	$days_of_week = array("Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");
	
	$stt = $db->prepare('SELECT id, first_name, second_name, last_name, description, picture FROM content_staff');
	$stt->execute();
	$staff = $stt->fetchAll(PDO::FETCH_NUM);
	
	$stt = $db->prepare('SELECT abonement, price, to_students, prolong FROM content_price');
	$stt->execute();
	$price = $stt->fetchAll(PDO::FETCH_NUM);
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-139045354-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			
			gtag('config', 'UA-139045354-1');
		</script>
		
		
		
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript" >
			(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
			m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
			(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
			
			ym(53442928, "init", {
				clickmap:true,
				trackLinks:true,
				accurateTrackBounce:true
			});
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/53442928" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->	
		
		<title>Йога центр Даулета Назарова - <?php echo $result[1]?></title>
		<link rel="stylesheet" href="/css/normalize.css">
		<link rel="stylesheet" href="/css/bootstrap_.css">
		<link rel="stylesheet" href="/css/style.css?r=<?php echo rand();?>">
		
		<!--<script src="js/jquery-3.2.1.js"></script>-->
		<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
	</head>
	<body class="ppage">
		
		<?php include $_SERVER['DOCUMENT_ROOT']."/workout/nav.php";?>
		
		<div class="breads-wrapper">
			<div class="container">
				<ul class="breads">
					
					<li><span><a href="/">ГЛАВНАЯ</a></span></li>
					<li>&gt;</li>
					<li class=\"active\"><span>Расписание</span></li>
					
				</ul>
			</div>
		</div>
		
		<div class="content" style="margin-bottom: 40px;">
			<div class="container">            
				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-9">
						<h1 class="content__header">                
							
						</h1>
						<div class="content__body">
							<table align="center" border="1" cellpadding="5" cellspacing="0" style="width:100%">
								<tbody>
									<tr>
										<td style="text-align:center">
											<p><strong>время</strong></p>
										</td>
										<td style="text-align:center">
											<p><strong>класс</strong></p>
										</td>
										<td style="text-align:center">
											<p><strong>залы</strong></p>
										</td>
										<td style="text-align:center">
											<p><strong>имя</strong></p>
										</td>
									</tr>
									<?php for($i = 0; $i < count($days_of_week); $i++):?>
									<tr>
										<td colspan="4" style="background-color:rgb(227, 168, 255); text-align:center">
											<p><strong><?php echo $days_of_week[$i]?></strong></p>
										</td>
									</tr>
									<?php 
										$dday = $i + 1;
										$stt = $db->prepare('SELECT id, note, timing, teacher, room FROM content_schedule WHERE day_ofweek = ? ORDER BY timing');
										$stt->bindParam(1, $dday);
										$stt->execute();
										$schedule = $stt->fetchAll(PDO::FETCH_NUM);
									?>
										<?php for($j = 0; $j < count($schedule); $j++):?>
										<tr>
											<td style="text-align:center">
												<p><?php echo $schedule[$j][2]?></p>
											</td>
											<td style="text-align:center">
												<p><?php echo $schedule[$j][1]?></p>
											</td>
											<td style="text-align:center">
												<p><?php echo $schedule[$j][4]?></p>
											</td>
											<td style="text-align:center">
												<?php for($k = 0; $k < count($staff); $k++):?>
												<?php if($staff[$k][0] == $schedule[$j][3]):?>
												<?php if($staff[$k][5] == ""):?>
												<p><?php echo $staff[$k][1]." ".$staff[$k][2]." ".$staff[$k][3]?></p>
												<?php else:?>
												<a href="#" data-toggle="modal" data-name="personel" data-target="#modal-<?php echo $staff[$k][0]?>"><?php echo $staff[$k][1]." ".$staff[$k][2]." ".$staff[$k][3]?></a>
												<?php endif;?>
												<?php endif;?>
												<?php endfor;?>

												
											</td>
										</tr>
										<?php endfor;?>
									<?php endfor;?>

								</tbody>
							</table>
							
							<p>&nbsp;</p>
							

													<table align="center" border="1" cellpadding="5" cellspacing="0" style="width:100%">
	<thead>
		<tr>
			<th scope="col" style="background-color: rgb(227, 168, 255); text-align: center;">Абонементы</th>
			<th scope="col" style="background-color: rgb(227, 168, 255); text-align: center;">стоимость</th>
			<th scope="col" style="background-color: rgb(227, 168, 255); text-align: center;">пенсионерам студентам&nbsp;</th>
			<th scope="col" style="background-color: rgb(227, 168, 255); text-align: center;">продление</th>
		</tr>
	</thead>
	<tbody>
		<?php for($i = 0; $i < count($price); $i++):?>
		<tr>
			<td style="text-align:center"><?php echo $price[$i][0];?></td>
			<td style="text-align:center"><?php echo $price[$i][1];?> тн.</td>
			<td style="text-align:center"><?php echo $price[$i][2];?></td>
			<td style="text-align:center"><?php echo $price[$i][3];?></td>
		</tr>
		<?php endfor;?>

	</tbody>
</table>
	<p>&nbsp;</p>							<p>&nbsp;</p>
				</div>
			</div>
					<div class="col-lg-2 col-md-2 col-sm-3">
						<div class="aside">
							<div class="aside__b">
								<h4 class="aside__b__heading">
								Преподаватели</h4>
								<div class="aside__b__content">
									<ul class="nav-aside">
										<?php for($i = 0; $i < count($staff); $i++):?>
										<?php if($staff[$i][5] !== ""):?>
										<li><a href="#" data-toggle="modal" data-target="#modal-<?php echo $staff[$i][0]?>"><?php echo $staff[$i][1]." ".$staff[$i][2]." ".$staff[$i][3]?></a></li>
										<?php endif;?>
										<?php endfor;?>
									<!--<li><a href="#" data-toggle="modal" data-target="#modal-jansulu">Жансулу Алимбекова</a></li>
									<li><a href="#" data-toggle="modal" data-name="personel" data-target="#modal-nargiz">Наргиз Джаварова</a></li>
									<li><a href="#" data-toggle="modal" data-name="personel" data-target="#modal-ninel">Неля Хашимова</a></li>	-->							
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include $_SERVER['DOCUMENT_ROOT']."/workout/footer.php";?>
		<?php for($i = 0; $i < count($staff); $i++):?>
		<?php if($staff[$i][5] !== ""):?>
		<div class="modal fade" id="modal-<?php echo $staff[$i][0]?>" role="dialog" aria-labelledby="selectCityLabel" aria-hidden="true" style=" padding-right: 15px;">
			<div class="modal-dialog" style="max-width:350px">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>
					<div class="modal-body" id="modal-text" style="display: inline-block"><img src="/media/<?php echo $staff[$i][5]?>" style="max-height:500px;max-width:300px;margin-right:5px;float:left">
						<p><b><?php echo $staff[$i][1]." ".$staff[$i][2]." ".$staff[$i][3]?></b></p>
						<?php echo $staff[$i][4]?>
					</div>						
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<?php endif;?>
		<?php endfor;?>

	</body>
</html>