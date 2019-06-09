<?php
	include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';
 

	$city = 40;
	$cityName = "Новосибирск";
	if(isset($_GET['c'])){
		$cookie_name = "city";
		$cookie_value = $_GET['c'];
		$city = $_GET['c'];
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
	}
	else{
		if(!isset($_COOKIE["city"])) {
			$cookie_name = "city";
			$cookie_value = 40;
			$city = 40;
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
		}
		else {
			$city = $_COOKIE["city"];
		}
	}
	
	$stt = $db->prepare('SELECT id, title FROM shop_regioncity ORDER BY title ASC');
	$stt->execute();
	$cities = $stt->fetchAll(PDO::FETCH_NUM);	
	for($i = 0; $i < count($cities); $i++){
		if($cities[$i][0] === $city){
			$cityName = $cities[$i][1];
			break;
		}
	}		
	
	$stt = $db->prepare('SELECT id, title, href FROM content_navblock ORDER BY priority ASC');
	$stt->execute();
	$mainMenu = $stt->fetchAll(PDO::FETCH_NUM);
	
	//$pageReq = substr($_SERVER['SCRIPT_NAME'], 0, strlen($_SERVER['SCRIPT_NAME']) - strlen(strrchr($_SERVER['SCRIPT_NAME'], "/"))+1);


?>
<!DOCTYPE html>
<html lang="en">
<?php include $_SERVER['DOCUMENT_ROOT']."/workout/page/head.php"; ?>
<body>    
<?php include $_SERVER['DOCUMENT_ROOT']."/workout/page/invNav.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT']."/workout/page/modalCity.php"; ?>
<?php	
	if(isset($_GET['p'])){
		$pageReq = $_GET['p'];
	}
	else{
		$pageReq = 'about';
	}
	
	$stt = $db->prepare('SELECT content, title, heading, parent_id, id FROM content_pages WHERE slug = ?');
	$stt->bindParam(1, $pageReq);
	$stt->execute();
	$result = $stt->fetch();
	$k = 0;
	$parents = array();
	if (!is_null($result[3])){	
		
		$par = $result[3];
		do {
			$stt = $db->prepare('SELECT title, url, parent_id, slug FROM content_pages WHERE id = ?');
			$stt->bindParam(1, $par);
			$stt->execute();
			$parent = $stt->fetch();
			$parents[$k][0] = $parent[0];
			$parents[$k][1] = $parent[1];
			$parents[$k][2] = $parent[3];
			$par = $parent[2];			
			$k++;
		}while(!is_null($parent[2]));
	}
	$parents[$k][0] = "Главная";
	$parents[$k][1] = "/";
	$res = is_null($result[3]) ? $result[4] : $result[3];
	$stt = $db->prepare('SELECT title, url, slug FROM content_pages WHERE parent_id = ? AND is_active = 1 ORDER BY priority DESC');
	$stt->bindParam(1, $res);
	$stt->execute();
	$children = $stt->fetchAll(PDO::FETCH_NUM);	
?>

<div style="position:absolute; top:120px; left:20px"><a href="/admin/content/pages/item/?pages=<?php echo $result[4];?>">Вернуться к редактированию</a></div>

<div class="breads-wrapper">
	<div class="container">
		<ul class="breads">
	<?php
		for ($i = count($parents) - 1; $i > -1; $i--){
			if($parents[$i][0] == 'Главная'){
				echo "<li><a href=\"".$parents[$i][1]."\">".$parents[$i][0]."</a></li><li>&gt;</li>";
			}
			else{
				echo "<li><a href=\"/page/?p=".$parents[$i][2]."\">".$parents[$i][0]."</a></li><li>&gt;</li>";
			}
			
		}
		echo "<li class=\"active\">".$result[1]."</li>";
	?>
		</ul>
	</div>
</div>
<div class="content">
	<div class="container">            
		<div class="row">
			<div class="col-md-8">
				<h1 class="content__header">                
						<?php echo $result[2]; ?>                
				</h1>
				<div class="content__body">
					<?php echo $result[0]; ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="aside">
					<div class="aside__b">
						<h4 class="aside__b__heading">
						<?php
							if(!is_null($result[3])){
								echo $parents[0][0];
							}
							else{
								echo $result[1];
							}
						?>
						</h4>
						<div class="aside__b__content">
							<ul class="nav-aside">
								<?php
								for($i = 0; $i < count($children); $i++){
									echo "<li";
									if($children[$i][2] == $pageReq){
										echo " class='active'";
									}
									echo "><a href='/page/?p=".$children[$i][2]."'>".$children[$i][0]."</a></li>";
								}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/workout/footer.php"; ?>
<!-- MODALS -->
<?php include $_SERVER['DOCUMENT_ROOT']."/workout/page/modalMap.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/workout/noprint.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/workout/scrLoc.php"; ?>


<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/app.js?resetcache=1"></script>

<?php include $_SERVER['DOCUMENT_ROOT']."/workout/googleCode.php"; ?>


</body>
</html>
