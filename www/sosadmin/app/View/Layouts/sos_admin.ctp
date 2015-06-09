<!DOCTYPE html>
<html ng-app="app">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<title>SOS-MA</title>



		<?php
			echo $this->Html->css(array(
									'sos_admin/foundation/foundation.css',// <<< foundation

									//>>> menu abre e fecha
									'sos_admin/style.css',
									'sos_admin/slidebars.min.css',
									//<<< menu abre e fecha
								));
			?>


		<?php
			echo $this->Html->script(array(
										'sos_admin/vendor/modernizr.js',// <<< foundation


										'sos_admin/angular/angular.min.js',//<<< angular
										'sos_admin/app.js',//<<< angular
								));
			?>

		<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
		<script>tinymce.init({selector:'textarea'});</script>



		<script type="text/javascript">
			var webroot = "<?=$this->webroot?>";
		</script>



	</head>

	<body>
		<style type="text/css">
			textarea{height: 300px;}
			.text-center button{margin-top: 20px!important;}
		</style>


		<!-- A classe sb-slide faz o menu deslizar junto com a barra -->
		<div class="small-12 columns menu sb-slide">

			<div class="small-12 columns text-right">
				<ul>
					<!-- Menu para abrir a barra lateral da Direita -->
					<li><a class="sb-toggle-right" href="javascript:void(0);">Menu</a></li>
				</ul>
			</div>
		</div>

		<div id="sb-site">
			<div class="row">
				<div class="small-10 small-centered columns">
					<div class="content">
						<div id="logo-zoio"></div>

						<!--MIOLO DA PAGINA-->

				        <?php echo $this->Session->flash(); ?>
				        <?php echo $this->fetch('content'); ?>

				       <!--FIM MIOLO DA PAGINA-->

					</div>
				</div>
			</div>
		</div>

		<?php echo $this->element('sos_admin/menu') ?>

		<?php
			echo $this->Html->script(array(
										'sos_admin/jquery.js',

										//>>> menu abre e fecha
										'sos_admin/slidebars.min.js',
										'sos_admin/scripts.js',
										//<<< menu abre e fecha

										'sos_admin/foundation.min.js',//<<< foundation

								));
			?>



	    <script>
	      $(document).foundation();
	    </script>
		<!-- <<< foundation -->

	</body>
</html>
