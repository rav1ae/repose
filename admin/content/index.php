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
	<body class=" dashboard app-content">
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
				Content
			</div>
			<!-- Content -->
			<div id="content" class="colMS">
				<h1>Администрирование приложения YOG.KZ</h1>
				<div id="content-main">
					<div class="app-content module">
						<table>
							<caption>
								<a href="" class="section" title="Модели в приложении Content">Content</a>
							</caption>

							<tr class="model-navblock">
								<th scope="row"><a href="/admin/content/navblock/">Меню / Главное</a></th>
								<td><a href="/admin/content/navblock/add/" class="addlink">Добавить</a></td>
								<td><a href="/admin/content/navblock/" class="changelink">Изменить</a></td>
							</tr>
							<tr class="model-nav">
								<th scope="row"><a href="/admin/content/nav/">Меню / Элементы</a></th>
								<td><a href="/admin/content/nav/add/" class="addlink">Добавить</a></td>
								<td><a href="/admin/content/nav/" class="changelink">Изменить</a></td>
							</tr>

							<tr class="model-pages">
								<th scope="row"><a href="/admin/content/pages/">Страницы сайта</a></th>
								<td><a href="/admin/content/pages/add/" class="addlink">Добавить</a></td>
								<td><a href="/admin/content/pages/" class="changelink">Изменить</a></td>
							</tr>
							<tr class="model-news">
								<th scope="row"><a href="/admin/content/schedule/">Расписание</a></th>
								<td><a href="/admin/content/schedule/add/" class="addlink">Добавить</a></td>
								<td><a href="/admin/content/schedule/" class="changelink">Изменить</a></td>
							</tr>
							<tr class="model-staff">
								<th scope="row"><a href="/admin/content/staff/">Персонал</a></th>
								<td><a href="/admin/content/news/add/" class="addlink">&nbsp;</a></td>
								<td><a href="/admin/content/news/" class="changelink">&nbsp;</a></td>
							</tr>
							<tr class="model-event">
								<th scope="row"><a href="/admin/content/events/">Мероприятия</a></th>
								<td><a href="/admin/content/events/add/" class="addlink">Добавить</a></td>
								<td><a href="/admin/content/events/" class="changelink">Изменить</a></td>
							</tr>
							<tr class="model-staff">
								<th scope="row"><a href="/admin/content/price/">Прайсы</a></th>
								<td><a href="/admin/content/price/add/" class="addlink">&nbsp;</a></td>
								<td><a href="/admin/content/price/" class="changelink">&nbsp;</a></td>
							</tr>
							<tr class="model-staff">
								<th scope="row"><a href="/admin/content/blocks/">Блоки</a></th>
								<td><a href="/admin/content/blocks/add/" class="addlink">&nbsp;</a></td>
								<td><a href="/admin/content/blocks/" class="changelink">&nbsp;</a></td>
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