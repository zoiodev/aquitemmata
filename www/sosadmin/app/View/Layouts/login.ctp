<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'App TalkingHUB');
?><!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>zAdmin</title>
		
		
		<meta name="description" content="Documentation and reference library for ZURB Foundation. JavaScript, CSS, components, grid and more." />
		
		<!--
		<meta name="author" content="ZURB, inc. ZURB network also includes zurb.com" />
		<meta name="copyright" content="ZURB, inc. Copyright (c) 2013" />
		-->
		<?php
		echo $this->fetch('meta');
			
			
			
		echo $this->Html->css('../assets/css/foundation.css');
		echo $this->Html->css('talkinghub.css');
		
		
		echo $this->Html->script('../assets/js/vendor/modernizr.js');
		
		echo $this->fetch('css');
		//echo $this->fetch('script');
		?>
		<style>
		.center {
			margin-top: 17%;
		}
		</style>
	</head>
	<body>
	
	
		
		
				
		
		<!-- CONTENT -->
		<div class="row">
						
				
				
				<?php 
				echo $this->Session->flash();
				
				echo $this->fetch('content'); 
				?>
				
				
				
			
		</div>
		<!-- END CONTENT -->
		
		
		
		
		<!-- Footer -->
		<div class="row talkinghub-footer">
			<footer>
			</footer>
		</div>
		<!-- End Footer -->
		
		<script>
		var webroot = '<?=$this->webroot;?>';
		</script>
		
		<?php
		echo $this->Html->script('../assets/js/vendor/jquery.js');
		echo $this->Html->script('../assets/js/vendor/jquery-ui_min.js');
		echo $this->Html->script('../assets/js/foundation.min.js');
		echo $this->Html->script('../assets/tinymce/tinymce.min.js');
		echo $this->Html->script('geral.js');
		echo $this->fetch('script');
		?>
		<script>
			$(document).foundation();
		</script>
		<?php //echo $this->element('sql_dump'); ?>
	</body>
</html>