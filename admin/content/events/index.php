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
				$tempId = $_POST['_selected_action'][$i];
				$stt = $db->prepare('SELECT picture FROM content_news WHERE id = ?');
				$stt->bindParam(1, $tempId);
				$stt->execute();
				$resPic = $stt->fetch();
				if(count($resPic[0]) > 0){
					$oldumask = umask(0);
					chmod($_SERVER['DOCUMENT_ROOT'].'/media/'.$resPic[0], 0777);
					unlink($_SERVER['DOCUMENT_ROOT'].'/media/'.$resPic[0]);
					umask($oldumask);
				}
			}
			$stt = $db->prepare('DELETE FROM content_news WHERE id IN ('.$delCort.')');
			$stt->execute();
		}
	}
	if(isset($_GET['q'])){
		$likeString = '%'.filter_input(INPUT_GET, "q", FILTER_SANITIZE_STRING).'%';
		$stt = $db->prepare('SELECT id, title, is_active, created_at, date_at FROM content_news WHERE title LIKE ? ORDER BY created_at DESC');
		$stt->bindParam(1, $likeString);
		$stt->execute();
		$events = $stt->fetchAll(PDO::FETCH_NUM);
	}
	else{
		$stt = $db->prepare('SELECT id, title, is_active, created_at, date_at FROM content_news ORDER BY created_at DESC');
		$stt->execute();
		$events = $stt->fetchAll(PDO::FETCH_NUM);
	}
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Выберите мероприятие для изменения | Административный сайт YOG.KZ</title>
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
				&rsaquo; Мероприятия
			</div>
			<!-- Content -->
			<div id="content" class="flex">
				<h1>Выберите мероприятие для изменения</h1>
				<div id="content-main">
					<ul class="object-tools">
						<li>
							<a href="/admin/content/events/add/" class="addlink">
								Добавить мероприятие
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
									<option value="delete_selected">Удалить выбранные новости</option>
								</select></label><input class="select-across" name="select_across" type="hidden" value="0" />
								<button type="submit" class="button" title="Выполнить выбранное действие" name="index" value="0">Выполнить</button>
								<script type="text/javascript">var _actions_icnt="31";</script>
								<span class="action-counter">Выбрано 0 объектов из <?php echo count($events);?> </span>
							</div>
							<div class="results">
								<table id="result_list">
									<thead>
										<tr>
											<th scope="col"  class="action-checkbox-column">
												<div class="text"><span><input type="checkbox" id="action-toggle" /></span></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-title">
												<div class="text"><a href="?o=1.-3">Название</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-is_active">
												<div class="text"><a href="?o=2.-3">Показать на сайте</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="column-created_at">
												
												<div class="text"><a href="?o=3">Дата размещения</a></div>
												
											</th>
											<th scope="col"  class="column-created_at">
												<div class="text"><a href="?o=3">Дата проведения</a></div>
												</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i = 0; $i < count($events); $i++):?>
										<tr class="<?php echo (($i%2)>0?'row2':'row1')?>">
											<td class="action-checkbox"><input class="action-select" name="_selected_action[]" type="checkbox" value="<?php echo $events[$i][0]?>" /></td>
											
											<th class="field-title"><a href="/admin/content/events/item/?events=<?php echo $events[$i][0]?>"><?php echo $events[$i][1]?></a></th>
											
											<td class="field-is_active"><img src="/img/<?php echo ($events[$i][2] > 0 ?'icon-yes.gif':'icon-no.gif');?>" alt="True" /></td>
											
											<td class="field-created_at nowrap"><?php echo (empty($events[$i][3])?'Ничего':(date("d", strtotime($events[$i][3])).' '.get_month_name(date("m", strtotime($events[$i][3]))).' '.date("Y", strtotime($events[$i][3])).' г. '.date("h:m:s", strtotime($events[$i][3])))) ?></td>
											
											<td class="field-created_at nowrap"><?php echo (empty($events[$i][4])?'Ничего':(date("d", strtotime($events[$i][4])).' '.get_month_name(date("m", strtotime($events[$i][4]))).' '.date("Y", strtotime($events[$i][4])).' г. '.date("h:m:s", strtotime($events[$i][4])))) ?></td>
										</tr>
										<?php endfor;?>
									</tbody>
								</table>
							</div>
							<p class="paginator">
								<?php echo count($events);?> мероприятий
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