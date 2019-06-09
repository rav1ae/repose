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
	$username = '';
	$password1 = '';
	$password2 = '';
	$totalErr = false;
	$usernameErr = false;
	$password1Err = false;
	$password2Err = false;
	$passwordCheckErr = false;
	if(isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']){
		if(isset($_POST['username'])){
			$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
			if(!preg_match('/^[a-zA-Z0-9_]{2,20}$/u', $username)){
				$usernameErr = '<ul class="errorlist"><li>Введите корректный логин, сосотящий из латинских букв и/или цифр.</li></ul>';
				$totalErr = true;
			}
			else{
				$stt = $db->prepare('SELECT COUNT(*) FROM auth_user WHERE username = ?');
				$stt->bindParam(1, $username);
				$stt->execute();
				$user_count = $stt->fetch();
				if($user_count[0] > 0){
					$totalErr = true;
					$usernameErr = '<ul class="errorlist"><li>Такой логин уже зарегистрирован в системе.</li></ul>';
				}
			}
		}
		else{
			$usernameErr = true;
			$totalErr = true;
		}
		if(isset($_POST['password1'])){
			$password1 = $_POST['password1'];
			if(!preg_match('/^[a-zA-Z0-9_]{5,}$/', $password1)){
				$password1Err = true;
				$totalErr = true;
			}
		}
		else{
			$password1Err = true;
			$totalErr = true;
		}
		if(isset($_POST['password2'])){
			$password2 = $_POST['password2'];
			if(!preg_match('/^[a-zA-Z0-9_]{5,}$/', $password2)){
				$password2Err = true;
				$totalErr = true;
			}
		}
		else{
			$password2Err = true;
			$totalErr = true;
		}
		if($password1 != $password2){
			$passwordCheckErr = true;
			$totalErr = true;
		}
		if(!$passwordCheckErr && !$totalErr){
			$hash = base64_encode(md5($password1));
			$date_joined = date('Y-m-d H:i:s');
			$stt = $db->prepare('INSERT INTO auth_user (password, username, data_joined) VALUES (?, ?, ?)');
			$stt->bindParam(1, $hash);
			$stt->bindParam(2, $username);
			$stt->bindParam(3, $date_joined);
			$stt->execute();
			$insId = $db->lastInsertId();
			if(isset($_POST['_continue'])){
				Header('Location: /admin/shared/user/item/?user='.$insId);
			}
			else if(isset($_POST['_save'])){
				Header('Location: /admin/shared/user/');
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<meta charset="UTF-8">	
		<title>Добавить пользователь | Административный сайт YOG.KZ</title>
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
				&rsaquo; Добавить пользователь
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Добавить пользователя</h1>
				<div id="content-main">
					<form enctype="multipart/form-data" action="" method="post" id="user_form" novalidate><input type='hidden' name='csrf_token' value='<?php echo $_SESSION['csrf_token'];?>' />
						<p>Сначала введите имя пользователя и пароль. Затем вы сможете ввести больше информации о пользователе.</p>
						<div>
							<?php if($totalErr):?>
							<p class="errornote">
								Пожалуйста, исправьте ошибки ниже.
							</p>
							<?php endif;?>
							<fieldset class="module aligned wide">
								<div class="form-row<?php echo ($usernameErr ? ' errors' : '')?> field-username">
									<?php echo ($usernameErr ? $usernameErr : '')?>
									<div>
										<label class="required" for="id_username">Имя пользователя:</label>
										<input id="id_username" maxlength="30" name="username" type="text" value="<?php echo $username?>"/>
										<p class="help">Обязательное поле. Не более 30 символов. Только буквы, цифры и символы @/./+/-/_.</p>
									</div>
								</div>
								<div class="form-row<?php echo ($password1Err ? ' errors' : '')?> field-password1">
									<?php echo ($password1Err ? '<ul class="errorlist"><li>Это поле обязательно для заполнения.</li></ul>' : '')?>
									<div>
										<label class="required" for="id_password1">Пароль:</label>
										<input id="id_password1" name="password1" type="password" />
									</div>
								</div>
								<div class="form-row<?php echo ($password2Err ? ' errors' : '')?> field-password2">
									<?php echo ($password2Err ? '<ul class="errorlist"><li>Это поле обязательно для заполнения.</li></ul>' : '')?>
									<?php echo ($passwordCheckErr ? '<ul class="errorlist"><li>Пароли должны совпадать.</li></ul>' : '')?>
									<div>
										<label class="required" for="id_password2">Подтверждение пароля:</label>
										<input id="id_password2" name="password2" type="password" />
										<p class="help">Введите тот же пароль, что и выше, для подтверждения.</p>
									</div>
								</div>
							</fieldset>
							<script type="text/javascript">document.getElementById("id_username").focus();</script>
							<div class="submit-row">
								<input type="submit" value="Сохранить" class="default" name="_save" />
								<input type="submit" value="Сохранить и добавить другой объект" name="_addanother" />
								<input type="submit" value="Сохранить и продолжить редактирование" name="_continue" />
							</div>
							<script type="text/javascript">
								(function($) {
									$(document).ready(function() {
										$('form#user_form :input:visible:enabled:first').focus()
									});
								})(django.jQuery);
							</script>
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