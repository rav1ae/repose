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
	$itemId = filter_input(INPUT_GET, "block", FILTER_SANITIZE_NUMBER_INT);
	
	if(isset($_POST['csrfmiddlewaretoken'])/*  && has_rights("change_navblock") */){
		$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);	
		$priority = filter_input(INPUT_POST, "priority", FILTER_SANITIZE_NUMBER_INT);
		$href = filter_input(INPUT_POST, "href", FILTER_SANITIZE_STRING);		
		$stt = $db->prepare('UPDATE content_navblock SET title = ?, priority = ?, href = ? WHERE id = ?');
		$stt->bindParam(1, $title);
		$stt->bindParam(2, $priority);
		$stt->bindParam(3, $href);
		$stt->bindParam(4, $itemId);
		$stt->execute();
		
		for($i = 0; $i < (count($_POST['nav_page'])- 1); $i++){
			if($_POST['nav-'.$i.'-id'] != 0){
				$id = $_POST['nav-'.$i.'-id'];
				$title = $_POST['nav-'.$i.'-title'];
				$page_id = $_POST['nav_page'][$i];
				$href = $_POST['nav-'.$i.'-href'];
				$is_active = (isset($_POST['nav-'.$i.'-is_active']) ? '1' : '0');
				$priority = $_POST['nav-'.$i.'-priority'];
				$stt = $db->prepare('UPDATE content_nav SET title = ?, page_id = ?, href = ?, is_active = ?, priority = ? WHERE id = ?');
				$stt->bindParam(1, $title);
				$stt->bindParam(2, $page_id);
				$stt->bindParam(3, $href);
				$stt->bindParam(4, $is_active);
				$stt->bindParam(5, $priority);
				$stt->bindParam(6, $itemId);
				$stt->execute();
			}
			else{
				$title = $_POST['nav-'.$i.'-title'];
				$page_id = $_POST['nav_page'][$i];
				$href = $_POST['nav-'.$i.'-href'];
				$is_active = (isset($_POST['nav-'.$i.'-is_active']) ? '1' : '0');
				$priority = $_POST['nav-'.$i.'-priority'];
				$stt = $db->prepare('INSERT INTO content_nav (title, page_id, href, is_active, priority, block_id) VALUES (?, ?, ?, ?, ?, ?)');
				$stt->bindParam(1, $title);
				$stt->bindParam(2, $page_id);
				$stt->bindParam(3, $href);
				$stt->bindParam(4, $is_active);
				$stt->bindParam(5, $priority);
				$stt->bindParam(6, $itemId);
				$stt->execute();
			}
		}
		if(isset($_POST['_save'])){
			Header('Location: /admin/content/navblock/');
		}
		else if(isset($_POST['_addanother'])){
			Header('Location: /admin/content/navblock/add/');
		}
	}
	
	$stt = $db->prepare('SELECT id, title, href, priority FROM content_navblock WHERE id = ?');
	$stt->bindParam(1, $itemId);
	$stt->execute();
	$navblock = $stt->fetch();
	$stt = $db->prepare('SELECT id, title, block_id,  page_id, href, is_active, priority FROM content_nav WHERE block_id = ?');
	$stt->bindParam(1, $itemId);
	$stt->execute();
	$nav = $stt->fetchAll(PDO::FETCH_NUM);
	$stt = $db->prepare('SELECT id, title FROM content_pages');
	$stt->execute();
	$pages = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Изменить меню | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/forms.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/css/ie.css" /><![endif]-->
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
				&rsaquo; <?php echo $navblock[1];?>
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Изменить меню</h1>
				<div id="content-main">

					<form enctype="multipart/form-data" action="" method="post" id="navblock_form" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-title">
									<div>
										<label class="required" for="id_title">Название:</label>
										<input class="vTextField" id="id_title" maxlength="128" name="title" type="text" value="<?php echo $navblock[1];?>" />
									</div>
								</div>
								<div class="form-row field-priority">
									<div>
										<label class="required" for="id_priority">Приоритет:</label>
										<input class="vIntegerField" id="id_priority" name="priority" type="text" value="<?php echo $navblock[3];?>" />
										<p class="help">Порядковый номер блока</p>
									</div>
								</div>
								<div class="form-row field-href">
									<div>
										<label for="id_href">Ссылка:</label>
										<input class="vTextField" id="id_href" maxlength="128" name="href" type="text" value="<?php echo $navblock[2];?>" />
									</div>
								</div>
							</fieldset>
							<div class="inline-group" id="nav-group">
								<div class="tabular inline-related last-related">
									<input id="id_nav-TOTAL_FORMS" name="nav-TOTAL_FORMS" type="hidden" value="<?php echo count($nav)?>" /><input id="id_nav-INITIAL_FORMS" name="nav-INITIAL_FORMS" type="hidden" value="8" /><input id="id_set-MIN_NUM_FORMS" name="nav-MIN_NUM_FORMS" type="hidden" value="0" /><input id="id_nav-MAX_NUM_FORMS" name="nav-MAX_NUM_FORMS" type="hidden" value="1000" />
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
												<?php for($i = 0; $i < count($nav); $i++):?>
												<tr class="form-row row1 has_original"
												id="nav-<?php echo $i?>">
													<td class="original">
														<p>
															<?php echo $nav[$i][1]?>
														</p>
														<input id="id_nav-<?php echo $i?>-id" name="nav-<?php echo $i?>-id" type="hidden" value="<?php echo $nav[$i][0]?>" />
														<input id="id_nav-<?php echo $i?>-block" name="nav-<?php echo $i?>-block" type="hidden" value="1" />
													</td>
													<td class="field-page">
														<select id="id_nav-<?php echo $i; ?>-page" name="nav_page[]">
															<option value="">---------</option>
															<?php for($j = 0; $j < count($pages); $j++):?>
															<option value="<?php echo $pages[$j][0]?>"<?php echo ($pages[$j][0] == $nav[$i][3] ? ' selected="selected"':'')?>><?php echo $pages[$j][1]?></option>
															<?php endfor;?>
														</select>
													</td>
													<td class="field-title">
														<input class="vTextField" id="id_nav-<?php echo $i?>-title" maxlength="128" name="nav-<?php echo $i; ?>-title" type="text" value="<?php echo $nav[$i][1]?>"/>
													</td>
													<td class="field-href">
														<input class="vTextField" id="id_nav-<?php echo $i?>-href" maxlength="128" name="nav-<?php echo $i?>-href" type="text" value="<?php echo $nav[$i][4]?>"/>
													</td>
													<td class="field-is_active">
														<input <?php echo ($nav[$i][5] == 1 ? 'checked="checked" ' : '')?>id="id_nav-<?php echo $i?>-is_active" name="nav-<?php echo $i?>-is_active" type="checkbox" />
													</td>
													<td class="field-priority">
														<input class="vIntegerField" id="id_nav-<?php echo $i?>-priority" name="nav-<?php echo $i?>-priority" type="text" value="<?php echo $nav[$i][6]?>" />
													</td>
												</tr>
												<?php endfor;?>
												<tr class="form-row row2  empty-form"
												id="nav-empty">
													<td class="original">
														<input id="id_nav-__prefix__-id" name="nav-__prefix__-id" type="hidden" value="0"/>
														<input id="id_nav-__prefix__-block" name="nav-__prefix__-block" type="hidden" value="7" />
													</td>
													<td class="field-page">
														<select id="id_nav-__prefix__-page" name="nav_page[]">
															<option value="">---------</option>
															<?php for($j = 0; $j < count($pages); $j++):?>
															<option value="<?php echo $pages[$j][0]?>"><?php echo $pages[$j][1]?></option>
															<?php endfor;?>
														</select>
													</td>
													<td class="field-title">
														<input class="vTextField" id="id_nav-__prefix__-title" maxlength="128" name="nav-__prefix__-title" type="text" />
													</td>
													<td class="field-href">
														<input class="vTextField" id="id_nav-__prefix__-href" maxlength="128" name="nav-__prefix__-href" type="text" />
													</td>
													<td class="field-is_active">
														<input checked="checked" id="id_nav-__prefix__-is_active" name="nav-__prefix__-is_active" type="checkbox" value="1" />
													</td>
													<td class="field-priority">
														<input class="vIntegerField" id="id_nav-__prefix__-priority" name="nav-__prefix__-priority" type="text" />
													</td>
												</tr>
											</tbody>
										</table>
									</fieldset>
								</div>
							</div>
							<script type="text/javascript">
								(function($) {
									$("#nav-group .tabular.inline-related tbody tr").tabularFormset({
										prefix: "nav",
										adminStaticPrefix: '/admin/',
										addText: "Добавить еще один Элемент меню",
										deleteText: "Удалить"
									});
								})(django.jQuery);
							</script>
							<div class="submit-row">
								<input type="submit" value="Сохранить" class="default" name="_save" />
								<input type="submit" value="Сохранить и добавить другой объект" name="_addanother" />
								<input type="submit" value="Сохранить и продолжить редактирование" name="_continue" />
							</div>
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