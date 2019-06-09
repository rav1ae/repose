<?php
	include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';
	if(isset($_SESSION['current'])){
		if($_SESSION['current'] !== 'admin'){
			header('Location: /admin/login/');
		}
	}
	else{
		header('Location: /admin/login/');
	}
	if(isset($_POST['csrfmiddlewaretoken'])){
		$abonement = filter_input(INPUT_POST, "abonement", FILTER_SANITIZE_STRING);	
		$price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_INT);
		$to_students = filter_input(INPUT_POST, "to_students", FILTER_SANITIZE_STRING);
		$prolong = filter_input(INPUT_POST, "prolong", FILTER_SANITIZE_STRING);

		$stt = $db->prepare('INSERT INTO content_price (abonement, price, to_students, prolong) VALUES (?, ?, ?, ?)');
		$stt->bindParam(1, $abonement);
		$stt->bindParam(2, $price);
		$stt->bindParam(3, $to_students);
		$stt->bindParam(4, $prolong);
		$stt->execute();
		$insId = $db->lastInsertId();
		if(isset($_POST['_continue'])){
			Header('Location: /admin/content/price/item/?price='.$insId);
		}
		else if(isset($_POST['_save'])){
			Header('Location: /admin/content/price/');
		}
	}


	
	
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Добавить прайс | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/forms.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/jsi18n/"></script>
		<script type="text/javascript" src="/js/admin/core.js"></script>
		<script type="text/javascript" src="/js/admin/RelatedObjectLookups.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.min.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.init.js"></script>
		<script type="text/javascript" src="/js/admin/actions.min.js"></script>
		<script type="text/javascript" src="/js/admin/urlify.js"></script>
		<script type="text/javascript" src="/js/admin/prepopulate.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" app-content model-news change-form">
		<!-- Container -->
		<div id="container">
			<!-- Header -->
			<div id="header">
				<div id="branding">
					<h1 id="site-name"><a href="/admin/">Администрирование YOG.KZ</a></h1>
				</div>
				<div id="user-tools">
					Добро пожаловать,
					<strong><?php echo $_SESSION['username'];?></strong>.
					<a href="/admin/password_change/">Изменить пароль</a> /
					<a href="/admin/logout/">Выйти</a>
				</div>
			</div>
			<!-- END Header -->
			<div class="breadcrumbs">
				<a href="/admin/">Начало</a>
				&rsaquo; <a href="/admin/content/">Content</a>
				&rsaquo; <a href="/admin/content/price/">Прайсы</a>
				&rsaquo; Добавить прайс
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Добавить прайс</h1>
				<div id="content-main">
					<form enctype="multipart/form-data" action="" method="post" id="news_form" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-subtitle">
									<div>
										<label class="required" for="abonement">Абонемент:</label>
										<input class="vTextField" id="abonement" maxlength="100" name="abonement" type="text" />
									</div>
								</div>
								<div class="form-row field-slug">
									<div>
										<label class="required" for="price">Стоимость:</label>
										<input class="vTextField" id="price" maxlength="100" name="price" type="text" />
									</div>
								</div>
								<div class="form-row field-url">
									<div>
										<label class="required" for="to_students">Пенсионерам, студентам:</label>
										<input class="vTextField" id="to_students" maxlength="100" name="to_students" type="text" />
									</div>
								</div>
								<div class="form-row field-meta">
									<div>
										<label class="required" for="prolong">Продление:</label>
										<input class="vTextField" id="prolong" maxlength="100" name="prolong" type="text" />

									</div>
								</div>

							</fieldset>
							<div class="submit-row">
								<input type="submit" value="Сохранить" class="default" name="_save" />
								<input type="submit" value="Сохранить и добавить другой объект" name="_addanother" />
								<input type="submit" value="Сохранить и продолжить редактирование" name="_continue" />
							</div>
							<script type="text/javascript">
								(function($) {
									$(document).ready(function() {
										$('form#news_form :input:visible:enabled:first').focus()
									});
								})(django.jQuery);
							</script>

						</div>
					</form></div>
					<br class="clear" />
			</div>
			<!-- END Content -->
			<div id="footer"></div>
		</div>
		<!-- END Container -->
	</body>
</html>