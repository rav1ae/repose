<?php
	include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';
	setcookie ("PHPSESSID", "", time() - 3600);
	if(isset($_SESSION['current'])){
		if($_SESSION['current'] === 'admin'){
			header('Location: /admin/');
		}
	}	
	if(isset($_SESSION['csrf_token'])){
		$csrf_token = $_SESSION['csrf_token'];
	}
	else{
		$csrf_token = rand(1000000, 9999999);
		$_SESSION['csrf_token'] = $csrf_token;
	}
	$try = false;

	if(isset($_POST['csrf_token']) && $_POST['csrf_token'] == $csrf_token){
		$urername = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
		if (filter_var($urername, FILTER_VALIDATE_EMAIL)) {
			$stt = $db->prepare('SELECT password, first_name, last_name, email, id FROM auth_user WHERE email = ?');
			$stt->bindParam(1, $urername);
			$stt->execute();
			$user = $stt->fetch();
		}
		else if($urername != "" && $password != ""){
			$stt = $db->prepare('SELECT password, first_name, last_name, email, id FROM auth_user WHERE username = ?');
			$stt->bindParam(1, $urername);
			$stt->execute();
			$user = $stt->fetch();
		}

		if(count($user[0]) > 0 && base64_encode(md5($password)) == $user[0]){
			$_SESSION['username'] = $urername;
			$_SESSION['current'] = 'admin';
			$_SESSION['first_name'] = $user[1];
			$_SESSION['last_name'] = $user[2];
			$_SESSION['email'] = $user[3];
			$last_login = date('Y-m-d H:i:s');
			$stt = $db->prepare('UPDATE auth_user SET last_login = ? WHERE id = ?');
			$stt->bindParam(1, $last_login);
			$stt->bindParam(2, $user[4]);
			$stt->execute();
			header('Location: /admin/');			
		}
		else{
			$try = true;
		}
	}
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<meta charset="UTF-8">	
		<title>Войти | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/admin/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/admin/login.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<meta name="robots" content="NONE,NOARCHIVE" />

	</head>
	<body class=" login">
		<!-- Container -->
		<div id="container">
			<!-- Header -->
			<div id="header">
				<div id="branding">
					<h1 id="site-name"><a href="/admin/">Администрирование<br> YOG.KZ</a></h1>
				</div>
			</div>
			<!-- END Header -->
			<!-- Content -->
			<div id="content" class="colM">
				<div id="content-main">
					<form action="" method="post" id="login-form"><input type='hidden' name='csrf_token' value='<?php echo $csrf_token?>' />
						<div class="form-row">
							<label for="id_username" class="required">Имя пользователя:</label> <input id="id_username" maxlength="254" name="username" type="text" />
						</div>
						<div class="form-row">
							<label for="id_password" class="required">Пароль:</label> <input id="id_password" name="password" type="password" />
						</div>
						<div class="submit-row">
							<label>&nbsp;</label><input type="submit" value="Войти" />
						</div>
					</form>
					<div class="form-row">
						<label for="id_password" class="required"><a href="/admin/login/restore">Забыли пароль?</a></label>
					</div>
					<script type="text/javascript">
						document.getElementById('id_username').focus()
					</script>
				</div>
				<br class="clear" />
			</div>
			<!-- END Content -->
			<div id="footer"></div>
		</div>
		<!-- END Container -->
		<?php if($try):?>
		<script type="text/javascript">
		function s(id,pos){g(id).left=pos+'px';}
		function g(id){return document.getElementById(id).style;}
		function shake(id,a,d){
			c=a.shift();
			s(id,c);
			if(a.length>0){setTimeout(function(){shake(id,a,d);},d);}
			else{try{g(id).position='static';wp_attempt_focus();}catch(e){}}
		}
	document.addEventListener('DOMContentLoaded', function() {
		  var p=new Array(15,30,15,0,-15,-30,-15,0);
			p=p.concat(p.concat(p));
			var i=document.forms[0].id;
			g(i).position='relative';
			shake(i,p,20);
		}, false);
		</script>
		<?php endif;?>
	</body>
</html>