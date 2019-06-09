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
	if(isset($_POST['csrfmiddlewaretoken'])){
		
		$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);	
		$content = $_POST['content'];
		$link = filter_input(INPUT_POST, "link", FILTER_SANITIZE_NUMBER_INT);
		
		$stt = $db->prepare('UPDATE content_block SET title = ?, content = ?, link = ? WHERE id = ?');
		$stt->bindParam(1, $title);
		$stt->bindParam(2, $content);
		$stt->bindParam(3, $link);
		$stt->bindParam(4, $itemId);
		$stt->execute();
		if(isset($_POST['_save'])){
			Header('Location: /admin/content/blocks/');
		}
		else if(isset($_POST['_addanother'])){
			Header('Location: /admin/content/blocks/add/');
		}
	}	
	$stt = $db->prepare('SELECT id, title, content, link FROM content_block WHERE id = ?');
	$stt->bindParam(1, $itemId);
	$stt->execute();
	$block = $stt->fetch();
	
	$stt = $db->prepare('SELECT id, title FROM content_pages WHERE is_active = 1');
	$stt->execute();
	$pages = $stt->fetchAll(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Изменить блок | Административный сайт YOG.KZ</title>
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
				&rsaquo; <a href="/admin/content/blocks/">Блоки</a>
				&rsaquo; <?php echo $block[1];?>
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Изменить блок</h1>
				<div id="content-main">

					<form enctype="multipart/form-data" action="" method="post" id="news_form" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-subtitle">
									<div>
										<label class="required" for="title">Заголовок:</label>
										<input class="vTextField" id="title" maxlength="255" name="title" type="text" value="<?php echo $block[1]?>"/>
									</div>
								</div>
								<div class="form-row field-content">
									<div>
										<label class="required" for="id_content">Текст:</label>
										<div class="django-ckeditor-widget" data-field-id="id_content" style="display: inline-block;">
											<textarea cols="40" id="id_content" name="content" rows="10" data-processed="0" data-config='{"filebrowserWindowWidth": 940, "toolbar_Basic": [["Source", "-", "Bold", "Italic"]], "language": "ru-ru", "toolbar_Full": [["Styles", "Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker", "Undo", "Redo"], ["Link", "Unlink", "Anchor"], ["Image", "Flash", "Table", "HorizontalRule"], ["TextColor", "BGColor"], ["Smiley", "SpecialChar"], ["Source"]], "filebrowserUploadUrl": "/ckeditor/upload/", "extraPlugins": "iframedialog,files", "height": 291, "width": 835, "extraAllowedContent": "iframe[*]", "filebrowserBrowseUrl": "/ckeditor/browse/", "skin": "moono", "filebrowserWindowHeight": 725, "toolbar": [["Format", "Bold", "Italic", "Underline", "Strike", "SpellChecker"], ["NumberedList", "BulletedList", "Indent", "Outdent", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock"], ["TextColor", "BGColor", "FontSize"], ["Image", "Files", "Table", "Link", "Unlink", "SectionLink"], ["Undo", "Redo"], ["Source"]]}' data-id="id_content" data-type="ckeditortype"><?php echo $block[2]?></textarea>
										</div>
									</div>
								</div>
								<div class="form-row field-url">
									<div>
										<label class="required" for="link">Ссылка:</label>
										<select id="link" name="link">
											<?php for($i = 0; $i < count($pages); $i++):?>
											<option value="<?php echo $pages[$i][0]?>"<?php echo ($block[3] == $pages[$i][0] ? ' selected="selected"' : '')?>><?php echo $pages[$i][1]?></option>
											<?php endfor;?>
										</select>
										
									</div>
								</div>
								</fieldset>
								<div class="submit-row">
									<input type="submit" value="Сохранить" class="default" name="_save" />
									<input type="submit" value="Сохранить и добавить другой объект" name="_addanother" />
									<input type="submit" value="Сохранить и продолжить редактирование" name="_continue" />
								</div>
							</div>
						</form>
						</div>
						<br class="clear" />
				</div>
				<!-- END Content -->
				<div id="footer"></div>
			</div>
			<!-- END Container -->
		</body>
	</html>	