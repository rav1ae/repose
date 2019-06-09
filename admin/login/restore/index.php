<?php
	include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';
	if(isset($_SESSION['current'])){
		if($_SESSION['current'] === 'admin'){
			header('Location: /admin/');
		}
	}
	$captcha_error = false;
	$email_error = false;
	$form_sent = false;
	$form_correct = false;
	$form_error = false;
	$email_empty = false;
	setcookie ("PHPSESSID", "", time() - 3600);
	$email = "";
	if(isset($_POST['csrfmiddlewaretoken']) && $_POST['csrfmiddlewaretoken'] == $_SESSION['hash']){

		if(isset($_POST['captcha'])){
			if((filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_STRING)) && $_SESSION['secpic'] == $_POST['captcha']){				
			}
			else{
				$captcha_error = true;
				$form_error = true;
			}
		}
		if(isset($_POST["email"])){
			if($email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)){
				
			}
			else{
				$email_error = true;
				$form_error = true;
			}		
		}
		if(!$form_error){
			$form_correct = true;
			$hash_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);
			$link = "htts://yog.kz/admin/login/renewpass/?c=".$hash_code;
			$stt = $db->prepare('SELECT id FROM auth_user WHERE email = ?');
			$stt->bindParam(1, $email);
			$stt->execute();
			$resMail = $stt->fetchAll(PDO::FETCH_NUM);
			if(count($resMail) == 0){
				$email_empty = true;
			}
			else{
				$to = "rasikab@mail.ru";
				$subject = "YOG.KZ";
				$messageb = "
				<html>
				<head>
				  <title>Восстановление пароля на сайте YOG.KZ</title>
				</head>
				<body>
				<p>Если вы подали заявку на смену пароля, то для продолжения процедуры смены пройдите по ссылке: <a href=".$link.">".$link."</a></p>
				<p>Если вы не запрашивали смену пароля, то не предпринимайте никаких действий.</p>
				</body>
				</html>";
					  
				$headers = "From: Admin <noreply@yog.kz>\r\n".		
				"MIME-Version:1.0\r\n".
				"Content-Type:text/html;charset=utf-8\r\n";		
				if(mail($to, $subject, $messageb, $headers)){
				
					$now_date = date('Y-m-d H:i:s');
					$stt = $db->prepare('UPDATE auth_user SET renew_pass = ?, last_login = ? WHERE id = ?');
					$stt->bindParam(1, $hash_code);
					$stt->bindParam(2, $now_date);
					$stt->bindParam(3, $resMail[0][0]);					
					$stt->execute();
					$form_sent = true;
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
		<script type="text/javascript">window.__admin_media_prefix__ = "/static/admin/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" login">
		<!-- Container -->
		<div id="container">
			<!-- Header -->
			<div id="header">
				<div id="branding">
					<h1 id="site-name"><a href="/admin/">Восстановление пароля</a></h1>
				</div>
			</div>
			<!-- END Header -->
			<!-- Content -->
			<div id="content" class="colM">
			<?php if(!$form_correct):?>
				<div id="content-main">
					<form action="" method="post" id="login-form"><input type='hidden' name='csrfmiddlewaretoken' value='<?php echo $_SESSION['hash'];?>' />
						<div class="form-row">
							<label for="email" class="required">Ваш e-mail:<?php echo ($email_error ? "<font color='red'>E</font>" : "")?></label> <input id="email" maxlength="254" name="email" type="text" value="<?php echo $email;?>"/>
						</div>
						<div class="form-row">
							<label for="email" class="required">Текст с картинки: <?php echo ($captcha_error ? "<font color='red'>E</font>" : "")?></label> <input id="captcha" maxlength="254" name="captcha" type="text" style="width:109px"/>
							<img src="/captcha/" alt="captcha" class="captcha" />
						</div>
						<div class="submit-row">
							<label>&nbsp;</label><input type="submit" value="Отправить" />
						</div>
					</form>

					<script type="text/javascript">
						document.getElementById('email').focus()
					</script>
				</div>
				<?php else:?>
					<?php if($email_empty):?>
				<div id="content-main">
				Такой адрес электронной почты не зарегистрирован.
				</div>
					<?php elseif(!$form_sent):?>
				<div id="content-main">
				При отправке почты произошла ошибка. Повторите попытку позже.
				</div>
					<?php else:?>
				<div id="content-main">
				На адрес указанной электронной почты отправлен код для восстановления пароля.
				</div>
					<?php endif;?>
				<?php endif;?>
				<br class="clear" />
			</div>
			<!-- END Content -->
			<div id="footer"></div>
		</div>
		<!-- END Container -->
	</body>
</html>