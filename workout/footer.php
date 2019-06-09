<div id="fb-root"></div>
        <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&appId=429224087255854&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
	
	<footer style="background-color: rgba(0, 200, 200, 0.2);">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-xs-12 footer-center">					


					<iframe src='/inwidget/index.php?toolbar=false' scrolling='no' frameborder='no' style='border:none;width:260px;height:247px;overflow:hidden;float:left'></iframe>
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12 footer-center">					
					<img src="/img/icons/geolocation.png" style="width:50px;margin-bottom:15px;cursor:pointer;vertical-align: top;" data-toggle="modal" data-target="#modal-map" title="Геолокация" />

					<img src="/img/icons/responses.png" style="width:50px;margin-bottom:15px;margin-left:10px;cursor:pointer;vertical-align: top;" data-toggle="modal" data-target="#modal-responses" title="Ваши отзывы" />

					<p style="">
						<span><strong><a href="tel:+77017303396" style="text-decoration:none;color:#444444">+7 701 730 33 96</a></strong></span><br>
						<span><strong>Наш адрес:</strong></span><br>						
						<span><strong>Алматы, Толе Би 83, уг. ул. Сейфулина б/ц Амбасадор, 5 этаж</strong></span>
					</p>
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12 footer-center">	
					<div class="fb-like-box" style="position:relative; top: 0;float: right;" data-href="https://www.facebook.com/108yogoformulas" data-width="232" data-height="320" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
				</div>												
			</div>
						<!-- Yandex.Metrika informer -->
<!--<a href="https://metrika.yandex.kz/stat/?id=53442928&amp;from=informer"
	target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/53442928/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
	style="width:88px; height:31px; border:0;float:right;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="53442928" data-lang="ru" /></a>-->
	<!-- /Yandex.Metrika informer -->
		</div>

		</footer>
		<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/workout/modal_feedback.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/workout/modal_map.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/workout/modal_responses.php";?>
		<script>
			var Locations={0:{'lat':'43.25441863','lon':'76.93178319','title':'Йога центр Даулета Назарова','desc':''},}
		</script>
		<script src="/js/map.js"></script>
		<script>
			$(document).ready(function () {
				ymaps.ready(initMap);
			});

		</script>
