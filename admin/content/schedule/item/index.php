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
	$itemId = filter_input(INPUT_GET, "schedule", FILTER_SANITIZE_NUMBER_INT);
	if(isset($_POST['csrfmiddlewaretoken'])){
		
		$note = filter_input(INPUT_POST, "note", FILTER_SANITIZE_STRING);	
		$day_ofweek = filter_input(INPUT_POST, "day_ofweek", FILTER_SANITIZE_NUMBER_INT);
		$timing = filter_input(INPUT_POST, "timing", FILTER_SANITIZE_STRING);
		$teacher = filter_input(INPUT_POST, "teacher", FILTER_SANITIZE_NUMBER_INT);
		$room = filter_input(INPUT_POST, "room", FILTER_SANITIZE_NUMBER_INT);
		$stt = $db->prepare('UPDATE content_schedule SET note = ?, day_ofweek = ?, timing = ?, teacher = ?, room = ? WHERE id = ?');
		$stt->bindParam(1, $note);
		$stt->bindParam(2, $day_ofweek);
		$stt->bindParam(3, $timing);
		$stt->bindParam(4, $teacher);
		$stt->bindParam(5, $room);
		$stt->bindParam(6, $itemId);
		$stt->execute();
		if(isset($_POST['_save'])){
			Header('Location: /admin/content/schedule/');
		}
		else if(isset($_POST['_addanother'])){
			Header('Location: /admin/content/schedule/add/');
		}
	}	
	$stt = $db->prepare('SELECT id, note, day_ofweek, timing, teacher, room FROM content_schedule WHERE id = ?');
	$stt->bindParam(1, $itemId);
	$stt->execute();
	$schedule = $stt->fetch();

	$stt = $db->prepare('SELECT id, first_name, second_name, last_name FROM content_staff');
	$stt->execute();
	$staff = $stt->fetchAll(PDO::FETCH_NUM);
	
	$days_of_week = array("Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");
?>
<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<title>Изменить новость | Административный сайт YOG.KZ</title>
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
				&rsaquo; <a href="/admin/content/schedule/">Расписание</a>
				&rsaquo; <?php echo $schedule[1];?>
			</div>
			<!-- Content -->
			<div id="content" class="colM">
				<h1>Изменить занятие</h1>
				<div id="content-main">

					<form enctype="multipart/form-data" action="" method="post" id="news_form" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='kydoYqjOKkNwWiLVSQXuC4QFHXz8rO7S' />
						<div>
							<fieldset class="module aligned ">
								<div class="form-row field-subtitle">
									<div>
										<label class="required" for="note">Описание:</label>
										<textarea class="vLargeTextField" cols="40" id="note" name="note" rows="2"><?php echo $schedule[1];?></textarea>
										</div>
								</div>
								<div class="form-row field-slug">
									<div>
										<label class="required" for="day_ofweek">День недели:</label>
										<select id="day_ofweek" name="day_ofweek">
											<?php for($i = 0; $i < count($days_of_week); $i++):?>
												<option value="<?php echo ($i + 1)?>"<?php echo (($i + 1) == $schedule[2] ? ' selected="selected"' : '')?>><?php echo $days_of_week[$i]?></option>
											<?php endfor;?>
										</select>
										

									</div>
								</div>
								<div class="form-row field-url">
									<div>
										<label class="required" for="timing">Время:</label>
										<input class="vTextField" id="timing" maxlength="256" name="timing" type="text" value="<?php echo $schedule[3];?>" />
									</div>
								</div>
								<div class="form-row field-meta">
									<div>
										<label class="required" for="teacher">Преподаватель:</label>
										<select id="teacher" name="teacher">
										<?php for($i = 0; $i < count($staff); $i++):?>
										
											<option value="<?php echo $staff[$i][0]?>"<?php echo ($schedule[4] == $staff[$i][0] ? ' selected="selected"' : '')?>><?php echo $staff[$i][1]." ".$staff[$i][2]." ".$staff[$i][3]?></option>
										<?php endfor;?>
										</select>										
									</div>
								</div>
								<div class="form-row field-url">
									<div>
										<label class="required" for="room">Зал:</label>
										<input class="vTextField" id="room" maxlength="256" name="room" type="text" value="<?php echo $schedule[5];?>" />
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