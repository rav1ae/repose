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
			$stt = $db->prepare('DELETE FROM settings WHERE id IN ('.$delCort.')');
			$stt->execute();
		}
	}
	$stt = $db->prepare('SELECT COUNT(*) FROM settings');
	$stt->execute();
	$count = $stt->fetch();
	$cont = 100;
	$total = intval(($count[0] -1) / $cont);
	$pagenum = 0;
	$page = 1;
	if(isset($_GET['p'])){
		$page = intval($_GET['p']) + 1;
		$pagenum = intval($_GET['p']) * $cont;
		if($pagenum > ($count[0] + $cont)){
			$pagenum = $total * $cont;
			$page = $total + 1;
		}
	}
	$stt = $db->prepare('SELECT id, kee FROM settings');
	$stt->execute();
	$shared = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<meta charset="UTF-8">	
		<title>Выберите настройки для изменения | Административный сайт K-Trans Logistic</title>
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
	<body class=" app-shared model-registry change-list">
		<!-- Container -->
		<div id="container">
			<!-- Header -->
			<div id="header">
				<div id="branding">
					<h1 id="site-name"><a href="/admin/">Администрирование K-Trans Logistic</a></h1>
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
				&rsaquo; Значения реестра
			</div>
			<!-- Content -->
			<div id="content" class="flex">
				<h1>Выберите значение реестра для изменения</h1>
				<div id="content-main">
					<ul class="object-tools">
						<li>
							<a href="/admin/shared/registry/add/" class="addlink">
								Добавить значение реестра
							</a>
						</li>
					</ul>
					<div class="module" id="changelist">
						<form id="changelist-form" action="" method="post" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
							<div class="actions">
								<label>Действие: <select name="action">
									<option value="" selected="selected">---------</option>
									<option value="delete_selected">Удалить выбранные значения реестра</option>
								</select></label><input class="select-across" name="select_across" type="hidden" value="0" />
								<button type="submit" class="button" title="Выполнить выбранное действие" name="index" value="0">Выполнить</button>
								<script type="text/javascript">var _actions_icnt="<?php echo count($shared)?>";</script>
								<span class="action-counter">Выбрано 0 объектов из <?php echo count($shared)?> </span>
							</div>
							<div class="results">
								<table id="result_list">
									<thead>
										<tr>
											<th scope="col"  class="action-checkbox-column">
												<div class="text"><span><input type="checkbox" id="action-toggle" /></span></div>
												<div class="clear"></div>
											</th>
											<th scope="col"  class="column-__str__">
												<div class="text"><span>Значение реестра</span></div>
												<div class="clear"></div>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i = 0; $i < count($shared); $i++):?>
										<tr class="<?php echo (($i%2)>0?'row2':'row1')?>">
											<td class="action-checkbox"><input class="action-select" name="_selected_action[]" type="checkbox" value="<?php echo $shared[$i][0]?>" /></td>
											<th class="field-__str__"><a href="/admin/shared/registry/item/?reg=<?php echo $shared[$i][0]?>"><?php echo $shared[$i][1]?></a></th>
										</tr>
										<?php endfor;?>
									</tbody>
								</table>
							</div>
							<p class="paginator">
								<?php 
									echo ($page != 1 && $page > 4) ? '<a href="?p=0">1</a>' : '';
									echo ($page != 2 && $page > 5) ? '<a href="?p=1">2</a>' : '';echo ($page > 6) ? ' . . . ' : '';
									echo ($page - 3 > 0) ? '<a href="?p='.($page-4).'">'.($page-3).'</a>' : '';
									echo ($page - 2 > 0) ? '<a href="?p='.($page-3).'">'.($page-2).'</a>' : '';
									echo ($page - 1 > 0) ? '<a href="?p='.($page-2).'">'.($page-1).'</a>' : '';
									echo '<span class="this-page">'.$page.'</span>';
									echo ($page - 1 < $total) ? '<a href="?p='.($page).'">'.($page+1).'</a>' : '';
									echo ($page < $total) ? '<a href="?p='.($page+1).'">'.($page+2).'</a>' : '';
									echo ($page + 1 < $total) ? '<a href="?p='.($page+2).'">'.($page+3).'</a>' : '';
									echo ($page < ($total - 4)) ? ' . . . ' : '';
									echo ($page != ($total - 1) && $page < ($total - 3)) ? '<a href="?p='.($total - 1).'">'.$total.'</a>' : '';echo ($page != $total && $page < ($total - 2)) ? '<a href="?p='.$total.'" class="end">'.($total+1).'</a>' : '&nbsp;&nbsp;';
									echo $count[0]; ?>
								значения реестра
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