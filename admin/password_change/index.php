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
	$passOk = false;
	if(isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']){
		if(isset($_POST['password1'])){
			if(isset($_POST['password2'])){
				if($_POST['password1'] == $_POST['password2']){
					$username = $_SESSION['username'];
					$pass = base64_encode(md5($_POST['password1']));
					$stt = $db->prepare('UPDATE auth_user SET password = ? WHERE username = ?');
					$stt->bindParam(1, $pass);
					$stt->bindParam(2, $username);
					$stt->execute();
					$passOk = true;
				}
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Изменить пароль | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/admin/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/admin/forms.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/static/admin/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/jsi18n/"></script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" auth-user change-form">
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
				&rsaquo; Изменить пароль
			</div>
			<!-- Content -->
			<?php if($passOk):?>
			<div id="content" class="colM">
				<h1>Пароль успешно изменен</h1>
			</div>
			<?php else:?>
			<div id="content" class="colM">
				<div id="content-main">
					<form action="" method="post" id="user_form"><input type='hidden' name='csrf_token' value='<?php echo $_SESSION['csrf_token'];?>' />
						<div>
							<fieldset class="module aligned">
								<div class="form-row">
									<label for="id_password1" class="required">Пароль:</label> <input id="id_password1" name="password1" type="password" />
								</div>
								<div class="form-row">
									<label for="id_password2" class="required">Пароль (еще раз):</label> <input id="id_password2" name="password2" type="password" />
									<p class="help">Введите тот же пароль, что и выше, для подтверждения.</p>
								</div>
							</fieldset>
							<div class="submit-row">
								<input type="submit" value="Изменить пароль" class="default" />
							</div>
							<script type="text/javascript">document.getElementById("id_password1").focus();</script>
						</div>
					</form></div>
					<br class="clear" />
			</div>
			<?php endif;?>
			<!-- END Content -->
			<div id="footer"></div>
		</div>
		<!-- END Container -->
	</body>
</html>