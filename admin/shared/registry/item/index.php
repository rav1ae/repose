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
	$itemId = filter_input(INPUT_GET, "reg", FILTER_SANITIZE_NUMBER_INT);	
	if(isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']){
		$key = filter_input(INPUT_POST, "key", FILTER_SANITIZE_STRING);	
		$value = $_POST['value'];
		//$value = filter_input(INPUT_POST, "value", FILTER_SANITIZE_STRING);
		$stt = $db->prepare('UPDATE settings SET kee = ?, vallu = ? WHERE id = ?');
		$stt->bindParam(1, $key);
		$stt->bindParam(2, $value);
		$stt->bindParam(3, $itemId);
		$stt->execute();
		if(isset($_POST['_save'])){
			Header('Location: /admin/shared/registry/');
		}
		else if(isset($_POST['_addanother'])){
			Header('Location: /admin/shared/registry/add/');
		}
	}
	
	$stt = $db->prepare('SELECT s.id, s.kee, s.vallu FROM settings s WHERE id = ?');
	$stt->bindParam(1, $itemId);
	$stt->execute();
	$regisry = $stt->fetch();
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<meta charset="UTF-8">	
		<title>Изменить значение реестра | Административный сайт K-Trans Logistic</title>
		<link rel="stylesheet" type="text/css" href="/css/admin/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/admin/forms.css" />
		<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/static/admin/css/ie.css" /><![endif]-->
		<script type="text/javascript">window.__admin_media_prefix__ = "/static/admin/";</script>
		<script type="text/javascript">window.__admin_utc_offset__ = "21600";</script>
		<script type="text/javascript" src="/js/admin/jsi18n/"></script>
		<script type="text/javascript" src="/js/admin/core.js"></script>
		<script type="text/javascript" src="/js/admin/RelatedObjectLookups.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.min.js"></script>
		<script type="text/javascript" src="/js/admin/jquery.init.js"></script>
		<script type="text/javascript" src="/js/admin/actions.min.js"></script>
						<script type="text/javascript" src="/ckeditor/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="/ckeditor/ckeditor-init.js"></script>
		<meta name="robots" content="NONE,NOARCHIVE" />
	</head>
	<body class=" app-shared model-registry change-form">
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
				&rsaquo; <a href="/admin/shared/">Shared</a>
				&rsaquo; <a href="/admin/shared/registry/">Значения реестра</a>
				&rsaquo; <?php echo $regisry[1]?>
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Изменить значение реестра</h1>
				<div id="content-main">

					<form enctype="multipart/form-data" action="" method="post" id="registry_form" novalidate><input type='hidden' name='csrf_token' value='<?php echo $_SESSION['csrf_token'];?>' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-key">
									<div>
										<label class="required" for="id_key">Ключ:</label>
										<input class="vTextField" id="id_key" maxlength="255" name="key" type="text" value="<?php echo $regisry[1]?>" />
									</div>
								</div>
								<div class="form-row field-value">
									<div>
										<label class="required" for="text_ru">Содержимое (рус.):</label>
										<div class="django-ckeditor-widget" data-field-id="text_ru" style="display: inline-block;">
											<textarea cols="40" id="text_ru" name="value" rows="10" data-processed="0" data-config='{"filebrowserWindowWidth": 940, "toolbar_Basic": [["Source", "-", "Bold", "Italic"]], "language": "ru-ru", "toolbar_Full": [["Styles", "Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker", "Undo", "Redo"], ["Link", "Unlink", "Anchor"], ["Image", "Flash", "Table", "HorizontalRule"], ["TextColor", "BGColor"], ["Smiley", "SpecialChar"], ["Source"]], "filebrowserUploadUrl": "/ckeditor/upload/", "extraPlugins": "iframedialog,files", "height": 291, "width": 835, "extraAllowedContent": "iframe[*]", "filebrowserBrowseUrl": "/ckeditor/browse/", "skin": "moono", "filebrowserWindowHeight": 725, "toolbar": [["Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker"], ["NumberedList", "BulletedList", "Indent", "Outdent", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock"], ["Blockquote"], ["Image", "Files", "Table", "Link", "Unlink", "SectionLink"], ["Undo", "Redo"], ["Source"]]}' data-id="text_ru" data-type="ckeditortype"><?php echo $regisry[2]; ?></textarea>
										</div>
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