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
						$nname = '/media/staff/'. $fil;
						$imgSrc = 'staff/'.$fil;
						$oldumask = umask(0);
						if(move_uploaded_file($_FILES["picture"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$nname)){
							$picture = $imgSrc;
						}
						umask($oldumask);
					}
				}
			}
		}
		$last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_STRING);	
		$first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_STRING);
		$second_name = filter_input(INPUT_POST, "second_name", FILTER_SANITIZE_STRING);
		$description = $_POST['description'];
		$is_active = isset($_POST['is_active']) ? 1 : 0;
		
		$stt = $db->prepare('INSERT INTO content_staff (first_name, second_name, last_name, picture, is_active, description) VALUES (?, ?, ?, ?, ?, ?)');
		$stt->bindParam(1, $first_name);
		$stt->bindParam(2, $second_name);
		$stt->bindParam(3, $last_name);
		$stt->bindParam(4, $picture);
		$stt->bindParam(5, $is_active);
		$stt->bindParam(6, $description);
		$stt->execute();
		$insId = $db->lastInsertId();
		if(isset($_POST['_continue'])){
			Header('Location: /admin/content/staff/item/?item='.$insId);
		}
		else if(isset($_POST['_save'])){
			Header('Location: /admin/content/staff/');
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
	$stt = $db->prepare('SELECT id, title FROM staff_group ORDER BY id ASC');
	$stt->execute();
	$group = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Добавить персонал | Административный сайт YOG.KZ</title>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/forms.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/jsi18n/"></script>
		<script type="text/javascript" src="/js/admin/core.js"></script>
		<script type="text/javascript" src="/js/admin/admin/RelatedObjectLookups.js"></script>
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
				&rsaquo; <a href="/admin/content/staff/">Персонал</a>
				&rsaquo; Добавить персонал
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Добавить персонал</h1>
				<div id="content-main">
					<form enctype="multipart/form-data" action="" method="post" id="news_form" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-title">
									<div>
										<label class="required" for="id_title">Фамилия:</label>
										<input class="vTextField" id="id_title" maxlength="100" name="second_name" type="text" />
									</div>
								</div>
								<div class="form-row field-slug">
									<div>
										<label class="required" for="id_first_name">Имя:</label>
										<input class="vTextField" id="id_first_name" maxlength="100" name="first_name" type="text" />
									</div>
								</div>
								<div class="form-row field-url">
									<div>
										<label class="required" for="id_url">Отчество:</label>
										<input class="vTextField" id="id_url" maxlength="100" name="last_name" type="text" />
									</div>
								</div>

								<div class="form-row field-description">
									<div>
										<label class="required" for="id_description">Описание:</label>
										<div class="django-ckeditor-widget" data-field-id="id_description" style="display: inline-block;">
											<textarea cols="40" id="id_description" name="description" rows="10" data-processed="0" data-config='{"filebrowserWindowWidth": 940, "toolbar_Basic": [["Source", "-", "Bold", "Italic"]], "language": "ru-ru", "toolbar_Full": [["Styles", "Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker", "Undo", "Redo"], ["Link", "Unlink", "Anchor"], ["Image", "Flash", "Table", "HorizontalRule"], ["TextColor", "BGColor"], ["Smiley", "SpecialChar"], ["Source"]], "filebrowserUploadUrl": "/ckeditor/upload/", "extraPlugins": "iframedialog,files", "height": 291, "width": 835, "extraAllowedContent": "iframe[*]", "filebrowserBrowseUrl": "/ckeditor/browse/", "skin": "moono", "filebrowserWindowHeight": 725, "toolbar": [["Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker"], ["NumberedList", "BulletedList", "Indent", "Outdent", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock"], ["Blockquote"], ["Image", "Files", "Table", "Link", "Unlink", "SectionLink"], ["Undo", "Redo"], ["Source"]]}' data-id="id_description" data-type="ckeditortype"></textarea>
										</div>
									</div>
								</div>
								<div class="form-row field-picture">
									<div>
										<label for="id_picture">Фото:</label>
										<input id="id_picture" name="picture" type="file" />
									</div>
								</div>
								<div class="form-row field-is_active">
									<div class="checkbox-row">
										<input checked="checked" id="id_is_active" name="is_active" type="checkbox" value="1" /><label class="vCheckboxLabel" for="id_is_active">Показать на сайте</label>
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