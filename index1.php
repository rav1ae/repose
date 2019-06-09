<?php include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';?>
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
	<meta name="yandex-verification" content="67b66adbc10740b9" />
	<title>Оздоровительный центр Даулета Назарова</title>
	<meta name="description" content="Йога центр Даулета Назарова в Алматы">
	<meta name="author" content="Ravshan Saliev rasikab@mail.ru">
	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/bootstrap_.css">
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>			
	<link rel="stylesheet" href="/css/style.css?r=<?php echo rand();?>">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body class="page">
	<?php include $_SERVER['DOCUMENT_ROOT']."/workout/nav.php";?>
<center>
	<div class="img-center">
		<img src="/img/lotos_cropped_sm.png" width="300">
	</div>
	<h1>Йога центр Даулета Назарова основан в 1997</h1>
</center>
<style>



</style>
<div id="second-block" style="background-position-y: -41px;position:relative">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12 inner-second-first" style="">
				<div class="inner-second">
					<h2 style="text-align:center">Книга перемен счастье внутри</h2>
<h4>Для кого?</h4>
					<p>Тем у кого казалось бы есть все — (положение, бизнес, дома, яхты и тому подобное), но нет внутренней удовлетворенности и чувства счастья.  </p>
<h4>Что произойдет после прохождения курса?</h4>
<p>На 100% трансформируетесь.
Обретете давно утраченное чувство внутреннего счастья. </p>
<span style="float:right;position:relative;bottom:20px"><a href="/page/?p=kniga-peremen-schaste-vnutri" class="btn btn-danger btn-xs"><strong>>>>>>>>></strong></a></span>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12 inner-second-second" style="">
				<div class="inner-second">
					<h2 style="text-align:center">Регрессивная йога терапия</h2>
<h4>Для кого?</h4>
					<p>Тем кто с возрастом всё меньше улыбается. 
У кого присутствует синдром хронической усталости. 
Тем чей ум все больше наполняется мыслями о проблемах, кризисе, страданиях.
У кого развилась негативная рефлекторно психо-эмоциональная реакция  на внешние стимулы.
У кого присутствует страх от прошлых неудач.
Иррациональное внутренние напряжение. </p>
<span style="float:right;position:relative;bottom:20px"><a href="/page/?p=regressivnaya-joga-terapiya" class="btn btn-danger btn-xs"><strong>>>>>>>>></strong></a></span>
				</div>
			</div>
		</div>
	</div>
</div>








<?php 
	

	$stt = $db->prepare('SELECT title, subtitle, picture, date_at, slug FROM content_news where is_active = 1 ORDER BY date_at');

	$stt->execute();
	$this_events = $stt->fetchAll(PDO::FETCH_NUM);	
	$now = date("Y-m-d");
	$active_date = 0;
	for($i = 0; $i < count($this_events); $i++){
		if($now < $this_events[$i][3]){
			$active_date = $i;
			break;
		}
	}

	
?>
<?php if(count($this_events) > 0):?>
<div id="two-and-half">
<h1 style="text-align:center">Календарь мероприятий</h1>
<div id="third-block">
</div>				
		<div id="event-slider" class="carousel slide event-slider" data-ride="carousel" data-interval="false">
			<div class="carousel-inner">
				
				<?php for($i = 0; $i < count($this_events); $i++):?>
				<div class="item five-five-zero<?php echo ($active_date == $i ? " active":"")?>" style="background-image:url(/media/<?php echo $this_events[$i][2]?>);height:500px;background-position:0 0;background-repeat:no-repeat;background-size:cover;padding-top:10px">
				<div class="container">
				<div class="row" style="">
					<div class="col-md-7">

						</div>

					<div class="col-md-5" style="height:330px;background-color:rgba(255, 255, 255, 0.8);border-radius:10px">
						<center><h3 style="color:red"><?php echo $this_events[$i][0]?></h3></center>
						<center><h3 style="color:black"><?php echo date("d", strtotime($this_events[$i][3]))." ".get_month_name(date("m", strtotime($this_events[$i][3])))." ".date("Y", strtotime($this_events[$i][3]))?></h3></center>
						<p style="height:148px;overflow:hidden;text-align: center;"><?php echo $this_events[$i][1]?></p>
						<center><a href="/event/?e=<?php echo $this_events[$i][4]?>" class="btn btn-lg btn-success" style="margin-right:5px">Подробнее...</a> <a href="#" data-toggle="modal" data-target="#modal-feedback" class="btn btn-lg btn-danger" style="">Подать заявку</a></center>
					</div>
				</div>
				</div>
				</div>
				<?php endfor;?>
				
			</div>
		  <ol class="carousel-indicators"  style="position:relative; text-indent:unset;left:0;margin-left:0; width:inherit;bottom: unset;margin-top: 5px;height:unset">
			<?php for($i = 0; $i < count($this_events); $i++):?>
			<li data-target="#event-slider" data-slide-to="<?php echo $i;?>" class="<?php echo ($active_date == $i ? "active":"")?>" style="width:200px;text-indent: unset;;height:unset">
				<div style="width:150px;height:100px;background-image:url(/media/<?php echo $this_events[$i][2]?>);background-size:cover">
					<div style="background-color:rgba(255, 255, 255, 0.8);white-space:nowrap"><?php echo $this_events[$i][0]?></div>
					<div style="color:#ffffff;background-color:rgba(0, 0, 0, 0.4);"><?php echo date("d", strtotime($this_events[$i][3]));?> <?php echo get_month_name(date("m", strtotime($this_events[$i][3])));?> <?php echo date("Y", strtotime($this_events[$i][3]));?></div>
				</div>
			</li>
			<?php endfor;?>

		  </ol>	

		</div>
		</div>
<?php else:?>
<div id="two-and-half">
<h1 style="text-align:center">Пусть счастье будет главной мотивацией всех ваших действий!</h1>
</div>	
<div id="third-block">
		<div id="third-one" class="third-pic">
		<img src="/img/pictures/001.jpg" style="width:370px">
	</div>
	<div id="third-two" class="third-pic">
		<img src="/img/pictures/002.jpg" style="width:370px">
	</div>
	<div id="third-three" class="third-pic">
		<img src="/img/pictures/003.jpg" style="width:370px">
	</div>
	<div id="third-four" class="third-pic">
		<img src="/img/pictures/004.jpg" style="width:370px">
	</div>
	<div id="third-nine" class="third-pic">
		<img src="/img/pictures/009.jpg" style="width:370px">
	</div>
	<div id="third-five" class="third-pic">
		<img src="/img/pictures/005.jpg" style="width:370px">
	</div>
	<div id="third-six" class="third-pic">
		<img src="/img/pictures/006.jpg" style="width:370px">
	</div>
	<div id="third-seven" class="third-pic">
		<img src="/img/pictures/007.jpg" style="width:370px">
	</div>
	<div id="third-eight" class="third-pic">
	<img src="/img/pictures/008.jpg" style="width:370px">
	</div>
	<div id="third-ten" class="third-pic">
		<img src="/img/pictures/010.jpg" style="width:370px">
	</div>		
				
</div>




<?php endif;?>


<div>
<h1 style="text-align:center">Увлекательное, интересное и познавательное путешествие в йогу и в глубь себя!<h1>
</div>
<div id="fourth-block">
		<div>
			<div class="container" style="margin-top:40px;">				
				<div class="row" style="margin-top: 50px;">
					<div class="col-md-2">
					</div>
					<div class="col-md-8" style="text-align:center;">
						<div style="position:relative;	padding-bottom:56.25%;	padding-top:30px;	height:0;	overflow:hidden;">
						<iframe width="100%" height="100%" style="border-radius: 30px;position:absolute;	top:0;	left:0;	width:100%;	height:100%;" src="https://www.youtube.com/embed/vvn1yDLu5t4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						</div>
					</div>
					<div class="col-md-2">
					</div>
				</div>
			</div>
		</div></div>
<?php include $_SERVER['DOCUMENT_ROOT']."/workout/footer.php";?>
<script>
$(document).scroll(function(){
	if (screen.width <= 699) {
		//$('#second-block').css('background-position-y', -$(document).scrollTop()/4 - 41);
	}
	else{
		
		$('#second-block').css('background-position-y', -$(document).scrollTop()/4 - 41);
	}	
});
function changeYear(year){
	alert(year);
}
</script>
</body>
</html>