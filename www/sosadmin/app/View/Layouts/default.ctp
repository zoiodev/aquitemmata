<?php 
	//$cakeDescription = __d('cake_dev', 'Ambev App');
// print_r($contentHome);

?>
<!DOCTYPE html>
<html>
<head>
	<title>SOS-MA</title>

	<?php 
			echo $this->Html->css(array(	
									'sos_admin/foundation/foundation.css',// <<< foundation
								));
			?>

		<?php 
			echo $this->Html->script(array(
										'sos_admin/vendor/modernizr.js',// <<< foundation
								));
			?>

		<script type="text/javascript">
			var webroot = "<?=$this->webroot?>";
		</script>	

</head>
<body>
	<div class="row">
		<div class="small-12 columns text-center">
			<h1>SOS-MA</h1>
		</div>
		<div class="small-12 columns">
			Texto recuperado do <strong>JSON:</strong> 
			
			<small>
				<p class="text-right">
					acesso admin SOS: 
					<a href="<?=$this->Html->url(array(
														'controller' => $this->params['controller'],
														'action' => $this->params['action'],
														'sos_admin' => true
													))?>">
					Click Aqui!
					</a>
				</p>
			</small>

			<br>
			<br>
			<br>
		</div>
		<div class="small-12 columns">
			<?php 
				echo $this->Session->flash();
				
				echo $this->fetch('content'); 
				?>
				
			
		</div>
			
			
		
	
	</div>

	<?php 
		echo $this->Html->script(array(	
									'sos_admin/jquery.js',
									'sos_admin/foundation.min.js',//<<< foundation
							));
		?>
    <script>
      $(document).foundation();
    </script>
</body>
</html>
