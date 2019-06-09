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


	$itemId = filter_input(INPUT_GET, "user", FILTER_SANITIZE_STRING);
	
 	if(isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']){
		$first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_STRING);
		$last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_STRING);
		$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
		$stt = $db->prepare('UPDATE auth_user SET first_name = ?, last_name = ?, email = ?  WHERE id = ?');
		$stt->bindParam(1, $first_name);
		$stt->bindParam(2, $last_name);
		$stt->bindParam(3, $email);
		$stt->bindParam(4, $itemId);
		$stt->execute();
		if(isset($_POST['_save'])){
			Header('Location: /admin/shared/user/');
		}
	
	}	
	$stt = $db->prepare('SELECT username, email, first_name, last_name, last_login FROM auth_user WHERE id = ?');
	$stt->bindParam(1, $itemId);
	$stt->execute();
	$user = $stt->fetch();
	


?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<meta charset="UTF-8">	
		<title>Изменить пользователя | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/admin/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/admin/forms.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/static/admin/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/jsi18n/"></script>
		<script type="text/javascript" src="/js/admin/core.js"></script>
		<script type="text/javascript" src="/js/admin/RelatedObjectLookups.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.min.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.init.js"></script>
		<script type="text/javascript" src="/js/admin/actions.min.js"></script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" app-auth model-user change-form">
		<!-- Container -->
		<div id="container">
			<!-- Header -->
			<div id="header">
				<div id="branding">
					<h1 id="site-name"><a href="/admin/">Администрирование YOG.KZ</a></h1>
				</div>
				<div id="user-tools">
					Добро пожаловать,
					<strong><?php echo $_SESSION['first_name'];?></strong>.
					<a href="/admin/password_change/">Изменить пароль</a> /
					<a href="/admin/logout/">Выйти</a>
				</div>
			</div>
			<!-- END Header -->
			<div class="breadcrumbs">
				<a href="/admin/">Начало</a>
				&rsaquo; <a href="/admin/shared/">Настройки сайта</a>
				&rsaquo; <a href="/admin/shared/user/">Пользователи</a>
				&rsaquo; <?php echo $user[2].' '.$user[3];?>
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Изменить пользователя</h1>
				<div id="content-main">
					<form enctype="multipart/form-data" action="" method="post" id="user_form" novalidate>
						<input type='hidden' name='csrf_token' value='<?php echo $_SESSION['csrf_token'];?>' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-username">
									<div>
										<label class="required" for="id_username">Логин: </label>
										<strong><?php echo $user[0];?></strong>
										<p class="help">Используется в качестве ключевого идентификатора пользователя в системе.</p>
									</div>
								</div>
							</fieldset>
							<fieldset class="module aligned ">
								<h2>Персональная информация</h2>
								<div class="form-row field-first_name">
									<div>
										<label for="id_first_name">Имя:</label>
										<input class="vTextField" id="id_first_name" maxlength="30" name="first_name" type="text" value="<?php echo $user[2];?>"/>
									</div>
								</div>
								<div class="form-row field-last_name">
									<div>
										<label for="id_last_name">Фамилия:</label>
										<input class="vTextField" id="id_last_name" maxlength="30" name="last_name" type="text" value="<?php echo $user[3];?>"/>
									</div>
								</div>
								<div class="form-row field-email">
									<div>
										<label for="id_email">E-mail:</label>
										<input class="vTextField" id="id_email" maxlength="75" name="email" type="email" value="<?php echo $user[1];?>" />
									</div>
								</div>
							</fieldset>
							<fieldset class="module aligned ">
								<h2>Важные даты</h2>
								<div class="form-row field-last_login">
									<div>
										<label class="required" for="id_last_login_0">Последний вход:</label>
										<p class="datetime">Дата: <?php echo date('d.m.Y', strtotime($user[4])); ?><br />Время: <?php echo date('H:i:s', strtotime($user[4])); ?></p>
									</div>
								</div>
							</fieldset>
							<div class="submit-row">
								<input type="submit" value="Сохранить" class="default" name="_save" />
								<input type="submit" value="Сохранить и продолжить редактирование" name="_continue" />
							</div>
							<script type="text/javascript">
								(function($) {
									var field;
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