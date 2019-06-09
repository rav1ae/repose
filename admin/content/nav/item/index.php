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
	$itemId = filter_input(INPUT_GET, "nav", FILTER_SANITIZE_NUMBER_INT);
	if(isset($_POST['csrfmiddlewaretoken'])/*  && has_rights("change_nav") */){	
		
		$block = filter_input(INPUT_POST, "block", FILTER_SANITIZE_NUMBER_INT);		
		$page = filter_input(INPUT_POST, "page", FILTER_SANITIZE_NUMBER_INT);		
		$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);		
		$href = filter_input(INPUT_POST, "href", FILTER_SANITIZE_STRING);
		$is_active = isset($_POST['is_active']) ? 1 : 0;		
		$priority = filter_input(INPUT_POST, "priority", FILTER_SANITIZE_NUMBER_INT);
		$stt = $db->prepare('SET FOREIGN_KEY_CHECKS=0;UPDATE content_nav SET block_id = ?, page_id = ?, title = ?, href = ?, is_active = ?, priority = ? WHERE id = ?;SET FOREIGN_KEY_CHECKS=1;');
		$stt->bindParam(1, $block);
		$stt->bindParam(2, $page);
		$stt->bindParam(3, $title);
		$stt->bindParam(4, $href);
		$stt->bindParam(5, $is_active);
		$stt->bindParam(6, $priority);
		$stt->bindParam(7, $itemId);
		$res = $stt->execute();
		if(isset($_POST['_save'])){
			Header('Location: /admin/content/nav/');
		}
		else if(isset($_POST['_addanother'])){
			Header('Location: /admin/content/nav/add/');
		}
	}

	$stt = $db->prepare('SELECT id, block_id, page_id, title, href, is_active, priority FROM content_nav WHERE id = ?');
	$stt->bindParam(1, $itemId);
	$stt->execute();
	$nav = $stt->fetch();
	$stt = $db->prepare('SELECT id, title FROM content_navblock');
	$stt->execute();
	$navblock = $stt->fetchAll(PDO::FETCH_NUM);
	$stt = $db->prepare('SELECT id, title FROM content_pages WHERE is_nav = 1');
	$stt->execute();
	$navpages = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Изменить элемент меню | Административный сайт YOG.KZ</title>
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
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" app-content model-nav change-form">
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
				&rsaquo; <a href="/admin/content/nav/">Меню / Элементы</a>
				&rsaquo;
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Изменить элемент меню</h1>
				<div id="content-main">

					<form enctype="multipart/form-data" action="" method="post" id="nav_form" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-block">
									<div>
										<label class="required" for="id_block">Block:</label>
										<select id="id_block" name="block">
											<option value="">---------</option>
											<?php for($i = 0; $i < count($navblock); $i++):?>
											<option value="<?php echo $navblock[$i][0]?>"<?php echo ($navblock[$i][0] == $nav[1] ? ' selected="selected"' : '')?>><?php echo $navblock[$i][1]?></option>
											<?php endfor;?>
										</select>
									</div>
								</div>
								<div class="form-row field-page">
									<div>
										<label for="id_page">Page:</label>
										<select id="id_page" name="page">
											<option value="">---------</option>
											<?php for($i = 0; $i < count($navpages); $i++):?>
											<option value="<?php echo $navpages[$i][0]?>"<?php echo ($navpages[$i][0] == $nav[2] ? ' selected="selected"' : '')?>><?php echo $navpages[$i][1]?></option>
											<?php endfor;?>
										</select>
									</div>
								</div>
								<div class="form-row field-title">
									<div>
										<label for="id_title">Название:</label>
										<input class="vTextField" id="id_title" maxlength="128" name="title" type="text" value="<?php echo $nav[3];?>"/>
										<p class="help">Если не задана страница</p>
									</div>
								</div>
								<div class="form-row field-href">
									<div>
										<label for="id_href">Ссылка:</label>
										<input class="vTextField" id="id_href" maxlength="128" name="href" type="text" value="<?php echo $nav[4];?>"/>
										<p class="help">Если не задана страница</p>
									</div>
								</div>
								<div class="form-row field-is_active">
									<div class="checkbox-row">
										<input <?php echo ($nav[5] == 1 ? 'checked="checked"' : '');?> id="id_is_active" name="is_active" type="checkbox" /><label class="vCheckboxLabel" for="id_is_active">Показать на сайте</label>
									</div>
								</div>
								<div class="form-row field-priority">
									<div>
										<label for="id_priority">Порядок:</label>
										<input class="vIntegerField" id="id_priority" name="priority" type="text" value="<?php echo $nav[6]?>" />
										<p class="help">Чем больше, тем выше пункт меню</p>
									</div>
								</div>
							</fieldset>
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