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
	if(isset($_POST['csrfmiddlewaretoken'])/*  && has_rights("add_navblock") */){
		$title = $_POST['title'];
		$priority = $_POST['priority'];
		$href = $_POST['href'];
		$stt = $db->prepare('INSERT INTO content_navblock (title, priority, href) VALUES (?, ?, ?)');
		$stt->bindParam(1, $title);
		$stt->bindParam(2, $priority);
		$stt->bindParam(3, $href);
		$stt->execute();
		$insId = $db->lastInsertId();
		for($i = 0; $i < count($_POST['nav_page']); $i++){
			$title = $_POST['nav-'.$i.'-title'];
			$page_id = $_POST['nav_page'][$i];
			$href = $_POST['nav-'.$i.'-href'];
			$is_active = (isset($_POST['nav-'.$i.'-is_active']) ? '1' : '0');
			$priority = $_POST['nav-'.$i.'-priority'];
			$stt = $db->prepare('INSERT INTO content_nav (title, page_id, block_id, href, is_active, priority) VALUES (?, ?, ?, ?, ?, ?)');
			$stt->bindParam(1, $title);
			$stt->bindParam(2, $page_id);
			$stt->bindParam(3, $insId);
			$stt->bindParam(4, $href);
			$stt->bindParam(5, $is_active);
			$stt->bindParam(6, $priority);
			$stt->execute();
		}
		if(isset($_POST['_continue'])){
			Header('Location: /admin/content/navblock/item/?block='.$insId);
		}
		else if(isset($_POST['_save'])){
			Header('Location: /admin/content/navblock/');
		}
	}

	$stt = $db->prepare('SELECT id, title FROM content_pages');
	$stt->execute();
	$pages = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Добавить меню | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/forms.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/core.js"></script>
		<script type="text/javascript" src="/js/admin/RelatedObjectLookups.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.min.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.init.js"></script>
		<script type="text/javascript" src="/js/admin/actions.min.js"></script>
		<script type="text/javascript" src="/js/admin/inlines.min.js"></script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" app-content model-navblock change-form">
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
				&rsaquo; <a href="/admin/content/navblock/">Меню / Главное</a>
				&rsaquo; Добавить меню
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Добавить меню</h1>
				<div id="content-main">
					<form enctype="multipart/form-data" action="" method="post" id="navblock_form" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-title">
									<div>
										<label class="required" for="id_title">Название:</label>
										<input class="vTextField" id="id_title" maxlength="128" name="title" type="text" />
									</div>
								</div>
								<div class="form-row field-priority">
									<div>
										<label class="required" for="id_priority">Приоритет:</label>
										<input class="vIntegerField" id="id_priority" name="priority" type="text" value="0" />
										<p class="help">Порядковый номер блока</p>
									</div>
								</div>
								<div class="form-row field-href">
									<div>
										<label for="id_href">Ссылка:</label>
										<input class="vTextField" id="id_href" maxlength="128" name="href" type="text" />
									</div>
								</div>
							</fieldset>
							<div class="inline-group" id="nav_set-group">
								<div class="tabular inline-related last-related">
									<input id="id_nav_set-TOTAL_FORMS" name="nav_set-TOTAL_FORMS" type="hidden" value="3" /><input id="id_nav_set-INITIAL_FORMS" name="nav_set-INITIAL_FORMS" type="hidden" value="0" /><input id="id_nav_set-MIN_NUM_FORMS" name="nav_set-MIN_NUM_FORMS" type="hidden" value="0" /><input id="id_nav_set-MAX_NUM_FORMS" name="nav_set-MAX_NUM_FORMS" type="hidden" value="1000" />
									<fieldset class="module">
										<h2>Меню / Элементы</h2>
										<table>
											<thead><tr>
												<th colspan="2">Page
												</th>
												<th>Название
													&nbsp;<img src="/img/icon-unknown.gif" class="help help-tooltip" width="10" height="10" alt="(Если не задана страница)" title="Если не задана страница" />
												</th>
												<th>Ссылка
													&nbsp;<img src="/img/icon-unknown.gif" class="help help-tooltip" width="10" height="10" alt="(Если не задана страница)" title="Если не задана страница" />
												</th>
												<th>Показать на сайте
												</th>
												<th>Порядок
													&nbsp;<img src="/img/icon-unknown.gif" class="help help-tooltip" width="10" height="10" alt="(Чем больше, тем выше пункт меню)" title="Чем больше, тем выше пункт меню" />
												</th>
											</tr></thead>
											<tbody>
												<?php for($i = 0; $i < 3; $i++):?>
												<tr class="form-row <?php echo (($i%2)>0?'row2':'row1')?> "
												id="nav_set-<?php echo $i; ?>">
													<td class="original">
														<input id="id_nav_set-<?php echo $i; ?>-id" name="nav_set[]" type="hidden" />
														<input id="id_nav_set-<?php echo $i; ?>-block" name="nav_set_block[]" type="hidden" />
													</td>
													<td class="field-page">
														<select id="id_nav_set-<?php echo $i; ?>-page" name="nav_page[]">
															<option value="" selected="selected">---------</option>
															<?php for($j = 0; $j < count($pages); $j++):?>
															<option value="<?php echo $pages[$j][0]?>"><?php echo $pages[$j][1]?></option>
															<?php endfor;?>
														</select>
													</td>
													<td class="field-title">
														<input class="vTextField" id="id_nav_set-0-title" maxlength="128" name="nav-<?php echo $i; ?>-title" type="text" value=""/>
													</td>
													<td class="field-href">
														<input class="vTextField" id="id_nav_set-0-href" maxlength="128" name="nav-<?php echo $i?>-href" type="text" value=""/>
													</td>
													<td class="field-is_active">
														<input checked="checked" id="id_nav_set-<?php echo $i?>-is_active" name="nav-<?php echo $i?>-is_active" type="checkbox" />
													</td>
													<td class="field-priority">
														<input class="vIntegerField" id="id_nav_set-0-priority" name="nav-<?php echo $i?>-priority" type="text" value="" />
													</td>
												</tr>
												<?php endfor;?>
											</tbody>
										</table>
									</fieldset>
								</div>
							</div>
							<div class="submit-row">
								<input type="submit" value="Сохранить" class="default" name="_save" />
								<input type="submit" value="Сохранить и добавить другой объект" name="_addanother" />
								<input type="submit" value="Сохранить и продолжить редактирование" name="_continue" />
							</div>
							<script type="text/javascript">
								(function($) {
									$(document).ready(function() {
										$('form#navblock_form :input:visible:enabled:first').focus()
									});
								})(django.jQuery);
							</script>
							<script type="text/javascript">
								(function($) {
									var field;
								})(django.jQuery);
							</script>
						</div>
					</form></div>
					<br class="clear" />
			</div>
			<!-- END Content -->
			<div id="footer"></div>
		</div>
		<!-- END Container -->
	</body>
</html>