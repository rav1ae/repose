<?php
include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';
if(isset($_SESSION['current'])){
	if($_SESSION['current'] === 'admin'){
		header('Location: /admin/');
	}
}
$time_out = false;
$empty_fetch = false;
$wrong_code = false;
$all_ok = false;
$passOk = false;
if(isset($_GET['c'])){
	if(strlen($_GET['c']) == 32){
		if(is_string($stto = $_GET['c'])){
			$stt = $db->prepare('SELECT last_login, id FROM auth_user WHERE renew_pass = ?');
			$stt->bindParam(1, $stto);
			$stt->execute();
			$res = $stt->fetch();
			if(count($res[0]) > 0){
				$passed = strtotime(date('Y-m-d H:i:s')) - strtotime($res[0]);
				if($passed < 259200){
					$all_ok = true;
				}
				else{
					$time_out = true;
				}
			}
			else{
				$empty_fetch = true;
			}				
		}
		else{
			$wrong_code = true;
		}
	}
	else{
		$wrong_code = true;
	}
}
if(isset($_POST['csrfmiddlewaretoken']) && $_POST['csrfmiddlewaretoken'] == $_SESSION['hash']){
	if(isset($_POST['password1'])){
		if(isset($_POST['password2'])){
			if($_POST['password1'] == $_POST['password2']){
				$userId = $_POST['user'];
				$pass = base64_encode(md5($_POST['password1']));
				$stt = $db->prepare('UPDATE auth_user SET password = ? WHERE id = ?');
				$stt->bindParam(1, $pass);
				$stt->bindParam(2, $userId);
				$stt->execute();
				$passOk = true;
				$all_ok = false;
			}
		}
	}
}
	$_SESSION['hash'] = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
?>
	<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Восстановление пароля YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/admin/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/admin/login.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/admin/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" login">
		<!-- Container -->
		<div id="container">
			<!-- Header -->
			<div id="header">
				<div id="branding">
					<h1 id="site-name">Восстановление пароля</h1>
				</div>
			</div>
			<!-- END Header -->
			<!-- Content -->
			<div id="content" class="colM">
			<?php if($wrong_code):?>
				<div id="content-main">
				Ссылка неверная.
				</div>
			<?php elseif($empty_fetch):?>
				<div id="content-main">
				Произошла ошибка.
				</div>
			<?php elseif($time_out):?>
				<div id="content-main">
				Ссылка устарела. Повторите процедуру восстановления.
				</div>
			<?php elseif($all_ok):?>
				<div id="content-main">
					<form action="" method="post" id="user_form"><input type='hidden' name='csrfmiddlewaretoken' value='<?php echo $_SESSION['hash'];?>' />
					<input type='hidden' name='user' value='<?php echo $res[1];?>' />
						
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
					</form>
				</div>
			<?php elseif($passOk):?>
				<div id="content-main">
				Процедура завершена.
				</div>
			<?php else:?>
				<div id="content-main">
				Произошла ошибка.
				</div>
			<?php endif;?>

				<br class="clear" />
			</div>
			<!-- END Content -->
			<div id="footer"></div>
		</div>
		<!-- END Container -->
	</body>
</html>