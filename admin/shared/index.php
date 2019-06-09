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
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<meta charset="UTF-8">	
		<title>Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/admin/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/admin/dashboard.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/static/admin/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" dashboard app-shared">
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
				&rsaquo;
				Shared
			</div>
			<!-- Content -->
			<div id="content" class="colMS">
				<h1>Администрирование приложения</h1>
				<div id="content-main">
					<div class="app-shared module">
						<table>
							<caption>
								<a href="/admin/shared/" class="section" title="Модели в приложении Shared">Настройки сайта</a>
							</caption>
							<!--<tr class="model-registry">
								<th scope="row"><a href="/admin/shared/registry/">Значения реестра</a></th>
								<td><a href="/admin/shared/registry/add/" class="addlink">Добавить</a></td>
								<td><a href="/admin/shared/registry/" class="changelink">Изменить</a></td>
							</tr>-->
							<tr class="model-user">
								<th scope="row"><a href="/admin/shared/user/">Пользователи</a></th>
								<td><a href="/admin/shared/user/add/" class="addlink">Добавить</a></td>
								<td><a href="/admin/shared/user/" class="changelink">Изменить</a></td>
							</tr>
						</table>
					</div>
				</div>
				<br class="clear" />
			</div>
			<!-- END Content -->
			<div id="footer"></div>
		</div>
		<!-- END Container -->
	</body>
</html>