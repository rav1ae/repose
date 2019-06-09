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
	if(isset($_POST['_selected_action'])){
		if($_POST['action'] == 'delete_selected'){
			$delCort = '';
			for($i=0;$i<count($_POST['_selected_action']);$i++){
				$delCort .= $_POST['_selected_action'][$i].(($i+1) < count($_POST['_selected_action']) ? ',' : '');
			}
			$stt = $db->prepare('DELETE FROM auth_user WHERE id IN ('.$delCort.')');
			$stt->execute();
		}
	}
	$stt = $db->prepare('SELECT id, username, email, first_name, last_name, last_login FROM auth_user ORDER BY id DESC');
	$stt->execute();
	$user = $stt->fetchAll(PDO::FETCH_NUM);

?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<meta charset="UTF-8">	
		<title>Выберите пользователь для изменения | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/admin/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/admin/changelists.css" />
		<script type="text/javascript" src="/js/admin/jsi18n/"></script>
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/static/admin/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/core.js"></script>
		<script type="text/javascript" src="/js/admin/RelatedObjectLookups.js"></script>
		<script type="text/javascript" src="/js/jquery.min.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.init.js"></script>
		<script type="text/javascript" src="/js/admin/actions.min.js"></script>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function($) {
					$("tr input.action-select").actions();
				});
			})(django.jQuery);
		</script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" app-auth model-user change-list">
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
				&rsaquo; Пользователи
			</div>
			<!-- Content -->
			<div id="content" class="flex">
				<h1>Выберите пользователя для изменения</h1>
				<div id="content-main">
					<ul class="object-tools">
						<li>
							<a href="/admin/shared/user/add/" class="addlink">
								Добавить пользователя
							</a>
						</li>
					</ul>
					<div class="module" id="changelist">
						<form id="changelist-form" action="" method="post" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
							<div class="actions">
								<label>Действие: <select name="action">
									<option value="" selected="selected">---------</option>
									<option value="delete_selected">Удалить выбранных пользователей</option>
								</select></label><input class="select-across" name="select_across" type="hidden" value="0" />
								<button type="submit" class="button" title="Выполнить выбранное действие" name="index" value="0">Выполнить</button>
								<script type="text/javascript">var _actions_icnt="<?php echo count($user)?>";</script>
								<span class="action-counter">Выбрано 0 объектов из <?php echo count($user)?> </span>
								<span class="all">Выбраны все <?php echo count($user)?></span>
								<span class="question">
									<a href="javascript:;" title="Нажмите здесь, чтобы выбрать объекты на всех страницах">Выбрать все пользователи (<?php echo count($user)?>)</a>
								</span>
								<span class="clear"><a href="javascript:;">Снять выделение</a></span>
							</div>
							<div class="results">
								<table id="result_list">
									<thead>
										<tr>
											<th scope="col"  class="action-checkbox-column">
												<div class="text"><span><input type="checkbox" id="action-toggle" /></span></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-username sorted ascending">
												<div class="sortoptions">
													<a class="sortremove" href="?o=" title="Удалить из сортировки"></a>
													<a href="?o=-1" class="toggle ascending" title="Сортировать в другом направлении"></a>
												</div>
												<div class="text"><a href="?o=-1">Имя пользователя</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-email">
												<div class="text"><a href="?o=2.1">Адрес электронной почты</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-first_name">
												<div class="text"><a href="?o=3.1">Имя</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-last_name">
												<div class="text"><a href="?o=4.1">Фамилия</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-created_at sorted descending">
												<div class="text"><a href="?o=3">Последний вход</a></div>
												<div class="clear"></div>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i = 0; $i < count($user); $i++):?>
										<tr class="<?php echo (($i%2)>0?'row2':'row1')?>">
											<td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="<?php echo $user[$i][0]?>" /></td>
											<th class="field-username"><a href="/admin/shared/user/item/?user=<?php echo $user[$i][0]?>"><?php echo $user[$i][1]?></a></th>
											<td class="field-email"><?php echo $user[$i][2]?></td>
											<td class="field-first_name"><?php echo $user[$i][3]?></td>
											<td class="field-last_name"><?php echo $user[$i][4]?></td>
											<td class="field-created_at nowrap"><?php echo (empty($user[$i][5])?'Ничего':(date("d", strtotime($user[$i][5])).' '.month(date("m", strtotime($user[$i][5]))).' '.date("Y", strtotime($user[$i][5])).' г. '.date("h:m:s", strtotime($user[$i][5])))) ?></td>
										</tr>
										<?php endfor;?>
									</tbody>
								</table>
							</div>
						</form>
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