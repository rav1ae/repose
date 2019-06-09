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
			$stt = $db->prepare('DELETE FROM content_schedule WHERE id IN ('.$delCort.')');
			$stt->execute();
		}
	}
	$stt = $db->prepare('SELECT id, note, day_ofweek, timing, teacher, room FROM content_schedule');
	$stt->execute();
	$schedule = $stt->fetchAll(PDO::FETCH_NUM);
	
	$days_of_week = array("Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");
	
	$stt = $db->prepare('SELECT id, first_name, second_name, last_name FROM content_staff');
	$stt->execute();
	$staff = $stt->fetchAll(PDO::FETCH_NUM);

?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Выберите занятие для изменения | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/changelists.css" />

		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/core.js"></script>
		<script type="text/javascript" src="/js/admin/admin/RelatedObjectLookups.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.min.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.init.js"></script>
		<script type="text/javascript" src="/js/admin/actions.min.js"></script>
		<script type="text/javascript" src="/js/admin/urlify.js"></script>
		<script type="text/javascript" src="/js/admin/prepopulate.min.js"></script>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function($) {
					$("tr input.action-select").actions();
				});
			})(django.jQuery);
		</script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" app-content model-news change-list">
		<!-- Container -->
		<div id="container">
			<!-- Header -->
			<div id="header">
				<div id="branding">
					<h1 id="site-name"><a href="/admin/">Администрирование YOG.KZ</a></h1>
				</div>
				<div id="user-tools">
					Добро пожаловать,
					<strong><?php echo $_SESSION['username'];?></strong>.
					<a href="/admin/password_change/">Изменить пароль</a> /
					<a href="/admin/logout/">Выйти</a>
				</div>
			</div>
			<!-- END Header -->
			<div class="breadcrumbs">
				<a href="/admin/">Начало</a>
				&rsaquo; <a href="/admin/content/">Content</a>
				&rsaquo; Расписание
			</div>
			<!-- Content -->
			<div id="content" class="flex">
				<h1>Выберите занятие для изменения</h1>
				<div id="content-main">
					<ul class="object-tools">
						<li>
							<a href="/admin/content/schedule/add/" class="addlink">
								Добавить занятие
							</a>
						</li>
					</ul>
					<div class="module" id="changelist">
						<div id="toolbar"><form id="changelist-search" action="" method="get">
							<div><!-- DIV needed for valid HTML -->
								<label for="searchbar"><img src="/img/icon_searchbox.png" alt="Search" /></label>
								<input type="text" size="40" name="q" value="" id="searchbar" />
								<input type="submit" value="Найти" />
							</div>
						</form></div>
						<script type="text/javascript">document.getElementById("searchbar").focus();</script>
						<form id="changelist-form" action="" method="post" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
							<div class="actions">
								<label>Действие: <select name="action">
									<option value="" selected="selected">---------</option>
									<option value="delete_selected">Удалить выбранные занятия</option>
								</select></label><input class="select-across" name="select_across" type="hidden" value="0" />
								<button type="submit" class="button" title="Выполнить выбранное действие" name="index" value="0">Выполнить</button>
								<script type="text/javascript">var _actions_icnt="31";</script>
								<span class="action-counter">Выбрано 0 объектов из <?php echo count($schedule);?> </span>
							</div>
							<div class="results">
								<table id="result_list">
									<thead>
										<tr>
											<th scope="col"  class="action-checkbox-column">
												<div class="text"><span><input type="checkbox" id="action-toggle" /></span></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-is_active">
												<div class="text"><a href="?o=2.-3">Тема</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-title">
												<div class="text"><a href="?o=1.-3">День недели</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-title">
												<div class="text"><a href="?o=1.-3">Время</a></div>
												<div class="clear"></div>
											</th>
											
											<th scope="col"  class="sortable column-is_active">
												<div class="text"><a href="?o=2.-3">Преподаватель</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-is_active">
												<div class="text"><a href="?o=2.-3">Зал</a></div>
												<div class="clear"></div>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i = 0; $i < count($schedule); $i++):?>
										<tr class="<?php echo (($i%2)>0?'row2':'row1')?>">
											<td class="action-checkbox"><input class="action-select" name="_selected_action[]" type="checkbox" value="<?php echo $schedule[$i][0]?>" /></td>
											
											<th class="field-title"><a href="/admin/content/schedule/item/?schedule=<?php echo $schedule[$i][0]?>"><?php echo $schedule[$i][1]?></a></th>
											
											<td class="field-is_active"><?php echo $days_of_week[$schedule[$i][2] - 1]?></td>
											<td class="field-is_active"><?php echo $schedule[$i][3]?></td>
											<?php for($j = 0; $j < count($staff); $j++):?>
												<?php if($staff[$j][0] == $schedule[$i][4]):?>
											<td class="field-is_active"><?php echo $staff[$j][1]." ".$staff[$j][2]." ".$staff[$j][3]?></td>
												<?php endif;?>
											<?php endfor;?>
											<td class="field-is_active"><?php echo $schedule[$i][5]?></td>
										</tr>
										<?php endfor;?>
									</tbody>
								</table>
							</div>
							<p class="paginator">
								<?php echo count($schedule);?> занятий
							</p>
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