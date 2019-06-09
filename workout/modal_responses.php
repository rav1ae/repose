<div class="modal fade" id="modal-responses" role="dialog" aria-labelledby="toggleMapLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<h3 style="text-align:center">ОТЗЫВЫ УЧЕНИКОВ</h3>
			</div>
            <div class="modal-body">
				
		<div id="main-slider" class="carousel slide main-slider" data-ride="carousel" data-interval="false">
			<div class="carousel-inner">
				<div class="item five-five-zero active">
					<iframe id="videoframe1" width="100%" height="315" style="" src="https://www.youtube.com/embed/JmAsHZAKPJc" frameborder="0" allowfullscreen></iframe>
				</div>
				<div class="item five-five-zero">
					<iframe id="videoframe2" width="100%" height="315" style="" src="https://www.youtube.com/embed/gQWPyFDNU8w" frameborder="0" allowfullscreen></iframe>
				</div>

			</div>

		  <ol class="carousel-indicators" style="bottom: -31px;">

			<li data-target="#main-slider" data-slide-to="0" class="left active"></li>
			<li data-target="#main-slider" data-slide-to="1" class="right" ></li>

		  </ol>
		</div>
				
				
				
				

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$('#modal-responses').on('show.bs.modal', function() {
    $("#videoframe1")[0].src += "?autoplay=0";
	$("#videoframe2")[0].src += "?autoplay=0";
});


$('#modal-responses').on('hidden.bs.modal', function(e) {
    var rawVideoURL = $("#videoframe1")[0].src;
    rawVideoURL = rawVideoURL.replace("?autoplay=1", "");
    $("#videoframe1")[0].src = rawVideoURL;
	
	var rawVideoURL2 = $("#videoframe2")[0].src;
    rawVideoURL2 = rawVideoURL2.replace("?autoplay=1", "");
    $("#videoframe2")[0].src = rawVideoURL2;
});

$(".carousel").on("slid.bs.carousel", function(event){
	var rawVideoURL = $("#videoframe1")[0].src;
    rawVideoURL = rawVideoURL.replace("?autoplay=1", "");
    $("#videoframe1")[0].src = rawVideoURL;
	
	var rawVideoURL2 = $("#videoframe2")[0].src;
    rawVideoURL2 = rawVideoURL2.replace("?autoplay=1", "");
    $("#videoframe2")[0].src = rawVideoURL2;
});
$(".carousel").on("touchstart", function(event){
		var xClick = event.originalEvent.touches[0].pageX;
	$(this).on("touchmove", function(event){
		var xMove = event.originalEvent.touches[0].pageX;
		if( Math.floor(xClick - xMove) > 5 ){
			$(this).carousel('next');
		}
		else if( Math.floor(xClick - xMove) < -5 ){
			$(this).carousel('prev');
		}
	});
	$(".carousel").on("touchend", function(){
			$(this).off("touchmove");
	});
});
</script>