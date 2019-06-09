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
			$stt = $db->prepare('DELETE FROM content_pages WHERE id IN ('.$delCort.')');
			$stt->execute();
		}
	}
	$stt = $db->prepare('SELECT p.id, p.title, (SELECT c.title FROM content_pages c WHERE c.id = p.parent_id GROUP BY c.id), p.slug, p.url, p.is_active, p.is_nav, p.priority, p.created_at, p.updated_at FROM content_pages p ORDER BY p.parent_id');
	$stt->execute();
	$pages = $stt->fetchAll(PDO::FETCH_NUM);

?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Выберите страницу для изменения | Административный сайт YOG.KZ</title>
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
	<body class=" app-content model-pages change-list">
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
				&rsaquo; Страницы сайта
			</div>
			<!-- Content -->
			<div id="content" class="flex">
				<h1>Выберите страницу для изменения</h1>
				<div id="content-main">
					<ul class="object-tools">
						<li>
							<a href="/admin/content/pages/add/" class="addlink">
								Добавить страницу
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
									<option value="delete_selected">Удалить выбранные Страницы сайта</option>
								</select></label><input class="select-across" name="select_across" type="hidden" value="0" />
								<button type="submit" class="button" title="Выполнить выбранное действие" name="index" value="0">Выполнить</button>
								<script type="text/javascript">var _actions_icnt="44";</script>
								<span class="action-counter">Выбрано 0 объектов из <?php echo count($pages); ?> </span>
							</div>
							<div class="results">
								<table id="result_list">
									<thead>
										<tr>
											<th scope="col"  class="action-checkbox-column">
												<div class="text"><span><input type="checkbox" id="action-toggle" /></span></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="column-page_title">
												<div class="text"><span>Page title</span></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-parent">
												<div class="text"><a href="?o=2.4">Parent</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-slug">
												<div class="text"><a href="?o=3.4">Ссылка</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-url sorted ascending">
												<div class="sortoptions">
													<a class="sortremove" href="?o=" title="Удалить из сортировки"></a>
													<a href="?o=-4" class="toggle ascending" title="Сортировать в другом направлении"></a>
												</div>
												<div class="text"><a href="?o=-4">Ключевые слова</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-is_active">
												<div class="text"><a href="?o=5.4">Показать на сайте</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-is_nav">
												<div class="text"><a href="?o=6.4">Добавить в основное меню</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-priority">
												<div class="text"><a href="?o=7.4">Приоритет</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-created_at">
												<div class="text"><a href="?o=8.4">Created at</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-updated_at">
												<div class="text"><a href="?o=9.4">Updated at</a></div>
												<div class="clear"></div>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i = 0; $i < count($pages); $i++):?>
										<tr class="<?php echo (($i%2)>0?'row2':'row1')?>">
											<td class="action-checkbox"><input class="action-select" name="_selected_action[]" type="checkbox" value="<?php echo $pages[$i][0]?>" /></td>
											<th class="field-page_title"><a href="/admin/content/pages/item/?pages=<?php echo $pages[$i][0]?>"><?php echo (empty($pages[$i][2])?'':' - ')?><?php echo $pages[$i][1]?></a></th>
											<td class="field-parent nowrap"><?php echo (empty($pages[$i][2])?'(Ничего)':$pages[$i][2])?></td>
											<td class="field-slug"><?php echo $pages[$i][3]?></td>
											<td class="field-url"><?php echo $pages[$i][4]?></td>
											<td class="field-is_active"><img src="/img/<?php echo ($pages[$i][5] == 1 ? 'icon-yes.gif' : 'icon-no.gif');?>" alt="True" /></td>
											<td class="field-is_nav"><img src="/img/<?php echo ($pages[$i][6] == 1 ? 'icon-yes.gif' : 'icon-no.gif');?>" alt="True" /></td>
											<td class="field-priority"><?php echo $pages[$i][7]?></td>
											<td class="field-created_at nowrap"><?php echo (empty($pages[$i][8])?'Ничего':(date("d", strtotime($pages[$i][8])).' '.get_month_name(date("m", strtotime($pages[$i][8]))).' '.date("Y", strtotime($pages[$i][8])).' г. '.date("H:i:s", strtotime($pages[$i][8])))) ?></td>
											<td class="field-updated_at nowrap"><?php echo (empty($pages[$i][9])?'Ничего':(date("d", strtotime($pages[$i][9])).' '.get_month_name(date("m", strtotime($pages[$i][9]))).' '.date("Y", strtotime($pages[$i][9])).' г. '.date("H:i:s", strtotime($pages[$i][9])))) ?></td>
										</tr>
										<?php endfor;?>
									</tbody>
								</table>
							</div>
							<p class="paginator">
								<?php echo count($pages); ?> Страницы сайта
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