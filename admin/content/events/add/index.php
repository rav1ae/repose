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
	if(isset($_POST['csrfmiddlewaretoken'])){
		$picture = '';
		if(isset($_FILES['picture'])){
			if($_FILES["picture"]["error"] == 0){
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$filetype = finfo_file($finfo, $_FILES['picture']['tmp_name']);
				finfo_close($finfo);
				if($filetype == 'image/jpeg' || $filetype == 'image/x-ms-bmp' || $filetype == 'image/gif' || $filetype == 'image/png' || $filetype == 'image/bmp'){
					$name = random_string(24);
					if ($exte = GetExt($_FILES['picture']['name'])){
						$fil = $name."." . $exte;
						$nname = '/media/events/'. $fil;
						$imgSrc = 'events/'.$fil;
						$oldumask = umask(0);
						if(move_uploaded_file($_FILES["picture"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$nname)){
							$picture = $imgSrc;
						}
						umask($oldumask);
					}
				}
			}
		}
		$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);	
		$slug = filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING);
		$subtitle = filter_input(INPUT_POST, "subtitle", FILTER_SANITIZE_STRING);
		$description = $_POST['description'];
		$is_active = isset($_POST['is_active']) ? 1 : 0;
		$created_at = date('Y-m-d H:i:s');
		$date_at = date('Y-m-d', (strtotime($_POST['date_at'])));
		$meta_desc = filter_input(INPUT_POST, "desc", FILTER_SANITIZE_STRING);
		$meta_keywords = filter_input(INPUT_POST, "keys", FILTER_SANITIZE_STRING);
		$stt = $db->prepare('INSERT INTO content_news (title, slug, subtitle, description, picture, is_active, created_at, date_at, meta_desc, meta_keywords) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$stt->bindParam(1, $title);
		$stt->bindParam(2, $slug);
		$stt->bindParam(3, $subtitle);
		$stt->bindParam(4, $description);
		$stt->bindParam(5, $picture);
		$stt->bindParam(6, $is_active);
		$stt->bindParam(7, $created_at);
		$stt->bindParam(8, $date_at);
		$stt->bindParam(9, $meta_desc);
		$stt->bindParam(10, $meta_keywords);
		$stt->execute();
		$insId = $db->lastInsertId();
		if(isset($_POST['_continue'])){
			Header('Location: /admin/content/events/item/?events='.$insId);
		}
		else if(isset($_POST['_save'])){
			Header('Location: /admin/content/events/');
		}
	}

	function GetExt($file){
		$ext=strtolower(substr(strrchr(basename($file), '.'), 1));
		switch ( $ext ){
			case 'jpeg': case 'jpg':
			return 'jpg';
			case 'gif':
			return $ext;
			case 'png':
			return $ext;
			case 'bmp':
			return $ext;
			default:
			return false;
		}
	}
	function random_string($length) {
		$key = '';
		$keys = array_merge(range(0, 9), range('a', 'z'));
		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}
		return $key;
	}
		$stt = $db->prepare('SELECT id, title FROM shop_regioncity ORDER BY title ASC');
	$stt->execute();
	$city = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Добавить новость | Административный сайт YOG.KZ</title>
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
		<script type="text/javascript" src="/js/calendar.js"></script>
		<script type="text/javascript" src="/js/admin/DateTimeShortcuts.js"></script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" app-content model-news change-form">
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
				&rsaquo; <a href="/admin/content/news/">Мероприятия</a>
				&rsaquo; Добавить мероприятие
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Добавить мероприятие</h1>
				<div id="content-main">
					<form enctype="multipart/form-data" action="" method="post" id="news_form" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-title">
									<div>
										<label class="required" for="id_title">Название:</label>
										<input class="vTextField" id="id_title" maxlength="255" name="title" type="text" />
									</div>
								</div>
								<div class="form-row field-slug">
									<div>
										<label class="required" for="id_slug">Ссылка:</label>
										<input class="vTextField" id="id_slug" maxlength="255" name="slug" type="text" />
									</div>
								</div>
								<div class="form-row field-url">
									<div>
										<label class="required" for="id_url">Meta description:</label>
										<input class="vTextField" id="id_url" maxlength="256" name="desc" type="text" />
									</div>
								</div>
								<div class="form-row field-meta">
									<div>
										<label class="required" for="id_metakeys">Meta keywords:</label>
										<input class="vTextField" id="id_keys" maxlength="255" name="keys" type="text" />
									</div>
								</div>
								<div class="form-row field-subtitle">
									<div>
										<label class="required" for="id_subtitle">Краткое описание:</label>
										<textarea class="vLargeTextField" cols="40" id="id_subtitle" name="subtitle" rows="10"></textarea>
									</div>
								</div>
								<div class="form-row field-description">
									<div>
										<label class="required" for="id_description">Описание:</label>
										<div class="django-ckeditor-widget" data-field-id="id_description" style="display: inline-block;">
											<textarea cols="40" id="id_description" name="description" rows="10" data-processed="0" data-config='{"filebrowserWindowWidth": 940, "toolbar_Basic": [["Source", "-", "Bold", "Italic"]], "language": "ru-ru", "toolbar_Full": [["Styles", "Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker", "Undo", "Redo"], ["Link", "Unlink", "Anchor"], ["Image", "Flash", "Table", "HorizontalRule"], ["TextColor", "BGColor"], ["Smiley", "SpecialChar"], ["Source"]], "filebrowserUploadUrl": "/ckeditor/upload/", "extraPlugins": "iframedialog,files", "height": 291, "width": 835, "extraAllowedContent": "iframe[*]", "filebrowserBrowseUrl": "/ckeditor/browse/", "skin": "moono", "filebrowserWindowHeight": 725, "toolbar": [["Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker"], ["NumberedList", "BulletedList", "Indent", "Outdent", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock"], ["TextColor", "BGColor", "FontSize"], ["Image", "Files", "Table", "Link", "Unlink", "SectionLink"], ["Undo", "Redo"], ["Source"]]}' data-id="id_description" data-type="ckeditortype"></textarea>
										</div>
									</div>
								</div>
								<div class="form-row field-picture">
									<div>
										<label for="id_picture">Изображение:</label>
										<input id="id_picture" name="picture" type="file" />
									</div>
								</div>
								<div class="form-row field-is_active">
									<div class="checkbox-row">
										<input checked="checked" id="id_is_active" name="is_active" type="checkbox" value="1" /><label class="vCheckboxLabel" for="id_is_active">Показать на сайте</label>
									</div>
								</div>
								<div class="form-row date_at">
									<div>
										<label for="id_date_at">Дата проведения:</label>
										<input class="vDateField" id="id_date_at" name="date_at" size="10" type="text" />
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
										$('form#news_form :input:visible:enabled:first').focus()
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
										maxLength: 255
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