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
	if(isset($_POST['_selected_action'])/*  && has_rights("delete_navblock") */){
		if($_POST['action'] == 'delete_selected'){
			$delCort = '';
			for($i=0;$i<count($_POST['_selected_action']);$i++){
				$postedItem = $_POST['_selected_action'][$i];
				$delCort .= $postedItem.(($i+1) < count($_POST['_selected_action']) ? ',' : '');
				$stt = $db->prepare('DELETE FROM content_nav WHERE block_id = ?');
				$stt->bindParam(1, $postedItem);
				$stt->execute();
			}
			$stt = $db->prepare('DELETE FROM content_navblock WHERE id IN ('.$delCort.')');
			$stt->execute();
		}
	}
	$stt = $db->prepare('SELECT id, title, href, priority FROM content_navblock');
	$stt->execute();
	$navblock = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Выберите меню для изменения | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/changelists.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/core.js"></script>
		<script type="text/javascript" src="/js/admin/RelatedObjectLookups.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.min.js"></script>
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
	<body class=" app-content model-navblock change-list">
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
				&rsaquo; Меню / Главное
			</div>
			<!-- Content -->
			<div id="content" class="flex">
				<h1>Выберите меню для изменения</h1>
				<div id="content-main">
					<ul class="object-tools">
						<li>
							<a href="/admin/content/navblock/add/" class="addlink">
								Добавить меню
							</a>
						</li>
					</ul>
					<div class="module" id="changelist">

						<form id="changelist-form" action="" method="post" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
							<div class="actions">
								<label>Действие: <select name="action">
									<option value="" selected="selected">---------</option>
									<option value="delete_selected">Удалить выбранные Меню / Главное</option>
								</select></label><input class="select-across" name="select_across" type="hidden" value="0" />
								<button type="submit" class="button" title="Выполнить выбранное действие" name="index" value="0">Выполнить</button>
								<script type="text/javascript">var _actions_icnt="5";</script>
								<span class="action-counter">Выбрано 0 объектов из <?php echo count($navblock);?> </span>
							</div>
							<div class="results">
								<table id="result_list">
									<thead>
										<tr>
											<th scope="col"  class="action-checkbox-column">
												<div class="text"><span><input type="checkbox" id="action-toggle" /></span></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-title sorted ascending">
												<div class="sortoptions">
													<a class="sortremove" href="?o=3" title="Удалить из сортировки"></a>
													<span class="sortpriority" title="Приоритет сортировки: 2">2</span>
													<a href="?o=3.-1" class="toggle ascending" title="Сортировать в другом направлении"></a>
												</div>
												<div class="text"><a href="?o=-1.3">Название</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-href">
												<div class="text"><a href="?o=2.3.1">Ссылка</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-priority sorted ascending">
												<div class="sortoptions">
													<a class="sortremove" href="?o=1" title="Удалить из сортировки"></a>
													<span class="sortpriority" title="Приоритет сортировки: 1">1</span>
													<a href="?o=-3.1" class="toggle ascending" title="Сортировать в другом направлении"></a>
												</div>
												<div class="text"><a href="?o=-3.1">Приоритет</a></div>
												<div class="clear"></div>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i = 0; $i < count($navblock); $i++):?>
										<tr class="<?php echo (($i%2)>0?'row2':'row1')?>">
											<td class="action-checkbox"><input class="action-select" name="_selected_action[]" type="checkbox" value="<?php echo $navblock[$i][0]; ?>" /></td>
											<th class="field-title"><a href="/admin/content/navblock/item/?block=<?php echo $navblock[$i][0]; ?>"><?php echo $navblock[$i][1]; ?></a></th>
											<td class="field-href"><?php echo $navblock[$i][2]; ?></td>
											<td class="field-priority"><?php echo $navblock[$i][3]; ?></td>
										</tr>
										<?php endfor;?>
									</tbody>
								</table>
							</div>
							<p class="paginator">
								<?php echo count($navblock); ?> Меню / Главное
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