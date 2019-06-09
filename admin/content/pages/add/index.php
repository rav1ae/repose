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
	if(isset($_POST['csrfmiddlewaretoken'])/*  && has_rights("add_pages") */){
		$stt = $db->prepare('SET FOREIGN_KEY_CHECKS=0');
		$stt->execute();
		$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
		$heading = filter_input(INPUT_POST, "heading", FILTER_SANITIZE_STRING);	
		$slug = filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING);
		$parent_id = filter_input(INPUT_POST, "parent", FILTER_SANITIZE_NUMBER_INT);
		$content = $_POST['content'];
		$is_active = isset($_POST['is_active']) ? 1 : 0;
		$is_nav = isset($_POST['is_nav']) ? 1 : 0;
		$priority = filter_input(INPUT_POST, "priority", FILTER_SANITIZE_NUMBER_INT);
		$created_at = date('Y-m-d H:i:s');
		$url = filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING);
		$meta_desc = filter_input(INPUT_POST, "desc", FILTER_SANITIZE_STRING);
		$meta_keywords = filter_input(INPUT_POST, "keys", FILTER_SANITIZE_STRING);
		$stt = $db->prepare('INSERT INTO content_pages (title, heading, slug, parent_id, content, is_active, is_nav, priority, created_at, url, meta_desc, meta_keywords) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$stt->bindParam(1, $title);
		$stt->bindParam(2, $heading);
		$stt->bindParam(3, $slug);
		$stt->bindParam(4, $parent_id);
		$stt->bindParam(5, $content);
		$stt->bindParam(6, $is_active);
		$stt->bindParam(7, $is_nav);
		$stt->bindParam(8, $priority);
		$stt->bindParam(9, $created_at);
		$stt->bindParam(10, $url);
		$stt->bindParam(11, $meta_desc);
		$stt->bindParam(12, $meta_keywords);
		$stt->execute();
		$insId = $db->lastInsertId();
		$stt = $db->prepare('SET FOREIGN_KEY_CHECKS=1');
		$stt->execute();
		if(isset($_POST['_continue'])){
			Header('Location: /admin/content/pages/item/?pages='.$insId);
		}
		else if(isset($_POST['_save'])){
			Header('Location: /admin/content/pages/');
		}
	}
	$stt = $db->prepare('SELECT id, title FROM content_pages');
	$stt->execute();
	$pages = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Добавить страницу | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/forms.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/jsi18n/"></script>
		<script type="text/javascript" src="/js/admin/core.js"></script>
		<script type="text/javascript" src="/js/admin/RelatedObjectLookups.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.min.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.init.js"></script>
		<script type="text/javascript" src="/js/admin/actions.min.js"></script>
		<script type="text/javascript" src="/js/admin/urlify.js"></script>
		<script type="text/javascript" src="/js/admin/prepopulate.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="/ckeditor/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="/ckeditor/ckeditor-init.js"></script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" app-content model-pages change-form">
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
				&rsaquo; <a href="/admin/content/pages/">Страницы сайта</a>
				&rsaquo; Добавить страницу
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Добавить страницу</h1>
				<div id="content-main">
					<form enctype="multipart/form-data" action="" method="post" id="pages_form" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-title">
									<div>
										<label class="required" for="id_title">Название страницы:</label>
										<input class="vTextField" id="id_title" maxlength="128" name="title" type="text" />
									</div>
								</div>
								<div class="form-row field-heading">
									<div>
										<label for="id_heading">Заголовок страницы:</label>
										<textarea class="vLargeTextField" cols="40" id="id_heading" name="heading" rows="10"></textarea>
										<p class="help">Отображается на странице</p>
									</div>
								</div>
								<div class="form-row field-slug">
									<div>
										<label class="required" for="id_slug">Ссылка:</label>
										<input class="vTextField" id="id_slug" maxlength="128" name="slug" type="text" />
									</div>
								</div>
								<div class="form-row field-url">
									<div>
										<label class="required" for="id_url">Meta description:</label>
										<input class="vTextField" id="id_url" maxlength="128" name="desc" type="text" />
									</div>
								</div>
								<div class="form-row field-meta">
									<div>
										<label class="required" for="id_metakeys">Meta keywords:</label>
										<input class="vTextField" id="id_keys" maxlength="255" name="keys" type="text" />
									</div>
								</div>
								<div class="form-row field-parent">
									<div>
										<label for="id_parent">Parent:</label>
										<select id="id_parent" name="parent">
											<option value="" selected="selected">---------</option>
											<?php for($i = 0; $i < count($pages); $i++):?>
											<option value="<?php echo $pages[$i][0];?>"><?php echo $pages[$i][1];?></option>
											<?php endfor;?>
										</select>
									</div>
								</div>
								<div class="form-row field-content">
									<div>
										<label class="required" for="id_content">Content:</label>
										<div class="django-ckeditor-widget" data-field-id="id_content" style="display: inline-block;">
											<textarea cols="40" id="id_content" name="content" rows="10" data-processed="0" data-config='{"filebrowserWindowWidth": 940, "toolbar_Basic": [["Source", "-", "Bold", "Italic"]], "language": "ru-ru", "toolbar_Full": [["Styles", "Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker", "Undo", "Redo"], ["Link", "Unlink", "Anchor"], ["Image", "Flash", "Table", "HorizontalRule"], ["TextColor", "BGColor"], ["Smiley", "SpecialChar"], ["Source"]], "filebrowserUploadUrl": "/ckeditor/upload/", "extraPlugins": "iframedialog,files", "height": 291, "width": 835, "extraAllowedContent": "iframe[*]", "filebrowserBrowseUrl": "/ckeditor/browse/", "skin": "moono", "filebrowserWindowHeight": 725, "toolbar": [["Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker"], ["NumberedList", "BulletedList", "Indent", "Outdent", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock"], ["TextColor", "BGColor", "FontSize"], ["Image", "Files", "Table", "Link", "Unlink", "SectionLink"], ["Undo", "Redo"], ["Source"]]}' data-id="id_content" data-type="ckeditortype"></textarea>
										</div>
									</div>
								</div>
								<div class="form-row field-is_active">
									<div class="checkbox-row">
										<input checked="checked" id="id_is_active" name="is_active" type="checkbox" value="1" /><label class="vCheckboxLabel" for="id_is_active">Показать на сайте</label>
									</div>
								</div>
								<div class="form-row field-is_nav">
									<div class="checkbox-row">
										<input checked="checked" id="id_is_nav" name="is_nav" type="checkbox" value="1" /><label class="vCheckboxLabel" for="id_is_nav">Добавить в основное меню</label>
									</div>
								</div>
								<div class="form-row field-priority">
									<div>
										<label class="required" for="id_priority">Приоритет:</label>
										<input class="vIntegerField" id="id_priority" name="priority" type="text" value="0" />
										<p class="help">Приоритет страницы в списке и меню</p>
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
									$(document).ready(function() {
										$('form#pages_form :input:visible:enabled:first').focus()
									});
								})(django.jQuery);
							</script>
							<script type="text/javascript">
								(function($) {
									var field;
									field = {
										id: '#id_slug',
										dependency_ids: [],
										dependency_list: [],
										maxLength: 128
									};
									field['dependency_ids'].push('#id_title');
									field['dependency_list'].push('title');
									$('.empty-form .form-row .field-slug, .empty-form.form-row .field-slug').addClass('prepopulated_field');
									$(field.id).data('dependency_list', field['dependency_list'])
									.prepopulate(field['dependency_ids'], field.maxLength);
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