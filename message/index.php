<?php
include $_SERVER['DOCUMENT_ROOT']."/workout/settings.php";
	
$sendError = false;
$errorName = false;
$errorPhone = false;
$errorMessage = false;
$errorCaptcha = false;
$errorCaptchaHash = false;
$errorEmail = false;
$name = '';
$phone = '';
$message = '';
$captcha = '';
$email = '';


if(isset($_POST['name'])){
	$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
	if($name == ''){
		$sendError = true;
		$errorName = true;
	}
}
if(isset($_POST['phone'])){
	$phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_STRING);
	if($phone == ''){
		$sendError = true;
		$errorPhone = true;
	}
}
if(isset($_POST['message'])){
	$message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);
	if($message == ''){
		$sendError = true;
		$errorMessage = true;
	}
}
if(isset($_POST['email'])){
	$email = test_input($_POST["email"]);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$sendError = true;
		$errorEmail = true;
	}
}
if(isset($_POST['captcha'])){
	$captcha = filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_STRING);
	if($captcha == ''){
		$sendError = true;
		$errorCaptcha = true;
	}
	if($_SESSION['secpic'] !== $captcha){
		$sendError = true;
		$errorCaptcha = true;
	}
}
if($sendError):
?>
	<div class="container" style="width:auto">
		<div class="form-group <?php echo ($errorName ? 'has-error' : 'has-success');?> has-feedback">
			<div class="col-sm-12">
				<input type="text" name="name" class="form-control" id="inputSuccess" value="<?php echo $name?>" placeholder="Некорректное имя">
				<span class="glyphicon glyphicon-<?php echo ($errorName ? 'remove' : 'ok');?> form-control-feedback"></span>
			</div>
		</div>
		<div class="form-group has <?php echo ($errorEmail ? 'has-error' : 'has-success');?> has-feedback">
			<div class="col-sm-12">
				<input type="text" name="email" class="form-control" value="<?php echo ($errorEmail ? '' : $email)?>" placeholder="Некорректный e-mail">
				<span class="glyphicon glyphicon-<?php echo ($errorEmail ? 'remove' : 'ok');?> form-control-feedback"></span>
			</div>
		</div>
		<div class="form-group <?php echo ($errorPhone ? 'has-error' : 'has-success');?> has-feedback">
			<div class="col-sm-12">
				<input type="text" name="phone" class="form-control" id="inputError" value="<?php echo $phone?>" placeholder="Некорректный телефон">
				<span class="glyphicon glyphicon-<?php echo ($errorPhone ? 'remove' : 'ok');?> form-control-feedback"></span>
			</div>
		</div>
		<div class="form-group <?php echo ($errorMessage ? 'has-error' : 'has-success');?> has-feedback">
			<div class="col-sm-12">
				<textarea class="form-control" name="message" id="message" style="width:100%" rows="8" placeholder="Некорректное сообщение"><?php echo $message;?></textarea>
				<span class="glyphicon glyphicon-<?php echo ($errorMessage ? 'remove' : 'ok');?> form-control-feedback"></span>
			</div>
		</div>	
		<div class="form-group <?php echo ($errorCaptcha ? 'has-error' : 'has-success');?> has-feedback">
			<label class="col-sm-3 control-label"><img src="/captcha/?pvc=01" alt="captcha" class="captcha" /></label> 
			<div class="col-sm-9">
				<input type="text" name="captcha" class="form-control" placeholder="<?php echo ($errorCaptcha ? 'Некорректный текст с картинки' : 'Текст с картинки');?>">
				<span class="glyphicon glyphicon-<?php echo ($errorCaptcha ? 'remove' : 'ok');?> form-control-feedback"></span>
			</div>	
		</div>
	</div>


<?php else:
/* 	$stt = $db->prepare("SELECT `value` FROM shared_registry WHERE `key` = 'feedback_email'");
	$stt->execute();
	$res = $stt->fetch(); */
	$to = "yogaradj@gmail.com";
	$subject = 'Yog.kz';
	$messageb = "
	<html>
	<head>
	  <title>Посетитель сайта yog.kz отправил сообщение.</title>
	</head>
	<body>
	<p>Посетитель <strong>".$name."</strong> оставил следующее сообщение: </p>
	<p>".$message."</p>
	<p>Телефон: ".$phone."</p>
	<p>E-mail: ".$email."</p>
	</body>
	</html>";
		  
	$headers = "From: Admin <noreply@yog.kz>\r\n".
	"MIME-Version:1.0\r\n".
	"Content-Type:text/html;charset=utf-8\r\n";
	if(mail($to, $subject, $messageb, $headers)):
		mail("rasikab@mail.ru", $subject, $messageb, $headers);
	?>
<h1>Ваше сообщение отправлено.</h1>
<?php else:?>
<h1>При отправке сообщения произошла ошибка.</h1>
<?php endif; ?>
<?php endif;

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}	
	
?>