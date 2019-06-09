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
	$rootPath = $_SERVER['DOCUMENT_ROOT'];
	if(isset($_POST['_selected_action'])/*  && has_rights("delete_nav") */){
		if($_POST['action'] == 'delete_selected'){
			$delCort = '';
			for($i=0;$i<count($_POST['_selected_action']);$i++){
				$delCort .= $_POST['_selected_action'][$i].(($i+1) < count($_POST['_selected_action']) ? ',' : '');
			}
			$stt = $db->prepare('DELETE FROM content_nav WHERE id IN ('.$delCort.')');
			$stt->execute();
		}
	}
	$stt = $db->prepare('SELECT cn.id, cn.title, (SELECT cb.title FROM content_navblock cb WHERE cb.id = cn.block_id), (SELECT cp.title FROM content_pages cp WHERE cp.id = cn.page_id), cn.href, cn.priority, cn.is_active FROM content_nav cn');
	$stt->execute();
	$nav = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Выберите элемент меню для изменения | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/changelists.css" />
		<!--<script type="text/javascript" src="/admin/jsi18n/"></script>-->
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/css/admin/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/static/admin/";</script>
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
	<body class=" app-content model-nav change-list">
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
				&rsaquo; Меню / Элементы
			</div>
			<!-- Content -->
			<div id="content" class="flex">
				<h1>Выберите элемент меню для изменения</h1>
				<div id="content-main">
					<ul class="object-tools">
						<li>
							<a href="/admin/content/nav/add/" class="addlink">
								Добавить элемент меню
							</a>
						</li>
					</ul>
					<div class="module" id="changelist">
						<div id="changelist-filter">

						</div>
						<form id="changelist-form" action="" method="post" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
							<div class="actions">
								<label>Действие: <select name="action">
									<option value="" selected="selected">---------</option>
									<option value="delete_selected">Удалить выбранные Меню / Элементы</option>
								</select></label><input class="select-across" name="select_across" type="hidden" value="0" />
								<button type="submit" class="button" title="Выполнить выбранное действие" name="index" value="0">Выполнить</button>
								<script type="text/javascript">var _actions_icnt="<?php echo count($nav)?>";</script>
								<span class="action-counter">Выбрано 0 объектов из <?php echo count($nav)?> </span>
							</div>
							<div class="results">
								<table id="result_list">
									<thead>
										<tr>
											<th scope="col"  class="action-checkbox-column">
												<div class="text"><span><input type="checkbox" id="action-toggle" /></span></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="column-nav_title">
												<div class="text"><span>Nav title</span></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-block">
												<div class="text"><a href="?o=2.-5">Block</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-page">
												<div class="text"><a href="?o=3.-5">Page</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-href">
												<div class="text"><a href="?o=4.-5">Ссылка</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-priority sorted descending">
												<div class="sortoptions">
													<a class="sortremove" href="?o=" title="Удалить из сортировки"></a>
													<a href="?o=5" class="toggle descending" title="Сортировать в другом направлении"></a>
												</div>
												<div class="text"><a href="?o=5">Порядок</a></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="sortable column-is_active">
												<div class="text"><a href="?o=6.-5">Показать на сайте</a></div>
												<div class="clear"></div>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i = 0; $i < count($nav); $i++):?>
										<tr class="<?php echo (($i%2)>0?'row2':'row1')?>">
											<td class="action-checkbox"><input class="action-select" name="_selected_action[]" type="checkbox" value="<?php echo $nav[$i][0]?>" /></td>
											<th class="field-nav_title"><a href="/admin/content/nav/item/?nav=<?php echo $nav[$i][0]?>"><?php echo ($nav[$i][1] == '' ? $nav[$i][3] : $nav[$i][1])?></a></th>
											<td class="field-block nowrap"><?php echo $nav[$i][2]?></td>
											<td class="field-page nowrap"><?php echo $nav[$i][3]?></td>
											<td class="field-href"><?php echo ($nav[$i][4] = '' ? '&nbsp;' : $nav[$i][4])?></td>
											<td class="field-priority"><?php echo $nav[$i][5]?></td>
											<td class="field-is_active"><img src="/img/<?php echo ($nav[$i][6] == 1 ? 'icon-yes.gif' : 'icon-no.gif');?>" alt="True" /></td>
										</tr>
										<?php endfor;?>
									</tbody>
								</table>
							</div>
							<p class="paginator">
								<?php echo count($nav)?> Меню / Элементы
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