<div class="modal fade" id="modal-feedback" role="dialog" aria-labelledby="selectCityLabel" aria-hidden="true">
    <div class="modal-dialog">
		<form id="ajax_form" method="post" action="" class="form-horizontal">
			<div class="modal-content">
				<div class="modal-header">
					<h3 style="margin:0;text-align:center"><span>Онлайн заявка</span></h3>
					<button type="button" class="close" style="position:absolute;top:10px;right:10px" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body" id="form-send">
					<div class="container" style="width:auto">
						<div class="form-group">
							<div class="col-sm-12">
								<input type="text" name="name" class="form-control" placeholder="Ваше имя">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<input type="text" name="email" class="form-control" placeholder="E-mail">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<input type="text" name="phone" class="form-control" placeholder="Телефон">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<textarea class="form-control" name="message" id="message" style="width:100%" rows="8" placeholder="Сообщение"></textarea>
							</div>
						</div>	
						<div class="form-group">
							<label class="col-sm-3 control-label"><img src="/captcha/?pvc=01" alt="captcha" class="captcha" /></label> 
							<div class="col-sm-9">
								<input type="text" name="captcha" class="form-control" placeholder="Текст с картинки">
							</div>	
						</div>
					</div>

				</div>
				
				<div class="modal-footer">

					<input type="button" id="btn-send"  class="form-control btn-default" value="Отправить">
				</div>
			</div>
			<!-- /.modal-content -->
		</form>
	</div>
    <!-- /.modal-dialog -->
	<script>
		$(document).ready(function(){ 		
			$("#btn-send").on('click', function(e){
				$.ajax({
					url: '/message/index.php',
					type : "POST", 
					processData: false,
					data : $("#ajax_form").serialize(), 
					dataType: 'html',
					success : function(html) {
						if(html.substring(0, 4) === "<h1>"){
							$("#btn-send").prop('disabled', true);
						}
						$("#form-send").html(html);				
					},
					error: function(xhr, resp, text) {
						console.log(xhr, resp, text);
					}
				})
			});
		});
	</script>
</div><!-- /.modal -->