<?php
	include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';

	if(isset($_GET['e'])){
		$pageReq = trim(filter_input(INPUT_GET, "e", FILTER_SANITIZE_STRING), '/');
	}
	else{
		$pageReq = 'about';
	}
	$stt = $db->prepare('SELECT title, description, picture, date_at, meta_keywords, meta_desc FROM content_news WHERE slug = ?');
	$stt->bindParam(1, $pageReq);
	$stt->execute();
	$result = $stt->fetch();
	
	$stt = $db->prepare("SELECT title, picture, date_at, slug FROM content_news WHERE is_active = 1 ORDER BY date_at DESC");
	$stt->bindParam(1, $pageReq);
	$stt->execute();
	$parent = $stt->fetchAll(PDO::FETCH_NUM);
	
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
		
		<title>Йога центр Даулета Назарова - <?php echo $result[0]?></title>
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
						<li><span>Мероприятия</span></li>
						<li>&gt;</li>
						<li class=\"active\"><span><?php echo $result[0]?></span></li>
			
				</ul>
			</div>
		</div>
			
	<div class="content" style="margin-bottom: 40px;">
		<div class="container">            
			<div class="row">
				<div class="col-lg-10 col-md-10 col-sm-9">
					<h1 class="content__header">                
							<?php echo $result[0]; ?>     
							<?php echo date("d", strtotime($result[3]));?> 
							<?php echo get_month_name(date("m", strtotime($result[3])));?> 
							<?php echo date("Y", strtotime($result[3]));?> 
					</h1>
					<img src="/media/<?php echo $result[2];?>" style="width:100%">
					<div class="content__body">
						<?php echo $result[1]; ?>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3">
					<div class="aside">
						<div class="aside__b">
							<h4 class="aside__b__heading">
							Мероприятия
							</h4>
							<div class="aside__b__content">
								<ul class="nav-aside">
									<?php
									for($i = 0; $i < count($parent); $i++):?>
										<li <?php echo ($parent[$i][3] == $pageReq ? "class='active'" : "")?>>

										<a href="/event/?e=<?php echo $parent[$i][3]?>" style="text-transform:unset;line-height: 22px;">
											<div style="width:150px;height:100px;background-image:url(/media/<?php echo $parent[$i][1]?>);background-size:cover">
												<span style="background-color:rgba(255, 255, 255, 0.8);"><?php echo $parent[$i][0]?></span><br>
												<span style="color:#ffffff;background-color:rgba(0, 0, 0, 0.4);">
													<?php echo date("d", strtotime($parent[$i][2]));?> 
													<?php echo get_month_name(date("m", strtotime($parent[$i][2])));?> 
													<?php echo date("Y", strtotime($parent[$i][2]));?> 
													</span>
											</div>
											
										</a></li>
									
									<?php endfor;?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT']."/workout/footer.php";?>
		<!--<div class="bottom-right"><a href="tel:+77088588357"><img src="/img/icons/oooo.png" style="width:38px;position:fixed; bottom:5px;right:5px;" title="+7 708 858 8357"></a></div>-->

</body>
</html>