<?php 
	$stt = $db->prepare('SELECT id, title, href FROM content_navblock ORDER BY priority ASC');
	$stt->execute();
	$mainMenu = $stt->fetchAll(PDO::FETCH_NUM);	
?>
		<nav class="navbar navbar-fixed-top navbar-default" role="navigation">

		<div class="top-add-menu">

				<div class="top-left-menu btn btn-default" style="cursor:pointer;margin-right:0;"><div data-toggle="modal" data-target="#modal-feedback"><img src="/img/icons/idea.png" style="width:20px;"> ПОДАТЬ ЗАЯВКУ</div></div>
				<div class="top-left-menu btn btn-default" style="float:right;cursor:pointer;margin-left:0;"><a href="tel:+77017303396" style="text-decoration:none;color:#444444"><img src="/img/icons/phone.png" style="width:20px;"> +7 701 730 33 96</a></div>

		</div>
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-default navbar-ex1-collapse" style="max-width: 704px;width: fit-content;overflow-y: hidden;">
				<ul class="nav navbar-nav">
					<li>
						<a href="/" class="clicker"><img src="/img/line_logo_yog.png" class="logo-image"></a>
					</li>
					
					<?php for($i = 0; $i < count($mainMenu); $i++):?>
                    <li class="dropdown">
						<?php 
							$stt = $db->prepare('SELECT c.title, p.slug, c.href FROM content_nav c LEFT JOIN content_pages p ON c.page_id = p.id WHERE c.block_id = ? AND c.is_active = 1 ORDER BY c.priority DESC');
							$stt->bindParam(1, $mainMenu[$i][0]);
							$stt->execute();
							$menuItems = $stt->fetchAll(PDO::FETCH_NUM);
							if(count($menuItems) > 0):
						?>
						
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
						aria-expanded="false"><?php echo $mainMenu[$i][1]; ?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php for($j = 0; $j < count($menuItems); $j++): ?>
							<?php if(empty($menuItems[$j][2])):?>
							<li><a href="/page/?p=<?php echo $menuItems[$j][1]; ?>"><?php echo $menuItems[$j][0]; ?></a></li>
							<?php else:?>
							<li><a href="<?php echo $menuItems[$j][2]; ?>"><?php echo $menuItems[$j][0]; ?></a></li>
							<?php endif;?>
							<?php endfor;?>
						</ul>
                        <?php else: ?>
						<a href="/<?php echo $mainMenu[$i][2];?>"><?php echo $mainMenu[$i][1]; ?></a>
                        <?php endif; ?>
					</li>
					<?php endfor;?>
				
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
<script>
$(document).ready(function () {
	if ($('.navbar-toggle').css('display') === 'none'){
		$('.navbar-default .navbar-nav > li.dropdown').hover(function () {
			$('ul.dropdown-menu', this).stop(true, true).slideDown('fast');
			$(this).addClass('open');
		}, function () {
			$('ul.dropdown-menu', this).stop(true, true).slideUp('fast');
			$(this).removeClass('open');
		});
	} 
});
var menu_on_top = false;
var prev_on_top = false;
$(document).scroll(function(){
	var scrol = $(document).scrollTop();
	if(scrol > 31){
		menu_on_top = true;
		if(!prev_on_top){
			$('.navbar-collapse').animate({ 'marginTop': '0px'}, 500);
			prev_on_top = true;
		}		
	}
	else{
		menu_on_top = false;
		if(prev_on_top){
			$('.navbar-collapse').animate({ 'marginTop': '31px'}, 500);
			prev_on_top = false;
		}
	}	
});
</script>