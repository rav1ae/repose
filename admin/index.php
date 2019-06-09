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
<html lang="en" >
	<head>
		<meta charset="UTF-8">	
		<title>Администрирование сайта YOG.KZ</title>

		<link rel="stylesheet" type="text/css" href="/css/base.css" />
				<link rel="stylesheet" type="text/css" href="/css/admin/base.css" />
<script type="text/javascript" src="/js/admin/jquery.min.js"></script>
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/admin/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<meta name="robots" content="NONE,NOARCHIVE" />
		
	</head>
	<body class=" dashboard">
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
				Начало
			</div>
			<!-- Content -->
			<div id="content" class="colMS">
				<h1>Администрирование приложения</h1>
				<div id="content-main">
					<div class="app-content module">
						<table>
							<caption>
								<a href="/admin/content/" class="section" title="Модели в приложении Content">Содержание</a>
							</caption>
							<tr class="model-offer">
								<th scope="row"><a href="/admin/content/staff/">Персонал</a></th>
								<td><a href="/admin/content/staff/add/" class="addlink">Добавить</a></td>
								<td><a href="/admin/content/staff/" class="changelink">Изменить</a></td>
							</tr>
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
					<style>

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}
.switch input {display:none;}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #f00;
  -webkit-transition: .4s;
  transition: .4s;
}
.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #0f0;
}

input:focus + .slider {
  box-shadow: 0 0 1px #0f0;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}	
					</style>
				</div>
				<br class="clear" />
			</div>
			<!-- END Content -->
			<div id="footer"></div>
		</div>
		<!-- END Container -->
	</body>
	<script>
		$('#site-switcher').on('change', function() {
			//alert($("#site-switcher").prop('checked'));
			//$('#site-switcher').prop('checked', true);
			var thceck = $("#site-switcher").prop('checked');
			$.ajax({
				type: "GET",
				url: '/switch',
				data: 'item=' + $("#site-switcher").prop('checked'),
				success: function (msg) {
					if(msg === '1'){
						if(thceck){
							$('#switch_state').html("Сайт включен");
						}
						else{
							$('#switch_state').html("Сайт выключен");
						}
					}
					else{
						
						if(thceck){
							$('#switch_state').html("Сайт включен");
							$("#site-switcher").prop('checked', (thceck ? false : true));
						}
						else{
							$('#switch_state').html("Сайт выключен");
							$("#site-switcher").prop('checked', (thceck ? false : true));
						}
					}
					
				}
			});
		});
	</script>
</html>