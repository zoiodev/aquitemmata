<?php

?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>zAdmin</title>

		<?=$this->Html->css(array(	'foundation.css',
									'zadmin.css'
									))?>

		<?=$this->Html->script(array('vendor/modernizr.js'))?>

		<?php
		echo $this->fetch('css');
		?>
		<script>
			var webroot = '<?=$this->webroot;?>';
		</script>

	</head>
	<body>
		<!-- Header and Nav -->
		<div class="row talkinghub-header">
			<!-- LOGO -->
			<div class="medium-3 small-5 columns">
				<h1>
					<a href="<?=$this->Html->url(array('controller' => 'index', 'action' => 'index'))?>">
						<?=$this->Html->image('logo_topo.png', array('alt' => 'Zóio'));?>
					</a>
				</h1>
			</div>
			<!-- END LOGO -->
			
			
			<!--- USER ACCESS --->
			<?php
			//print_r($current_user);
			if (!empty($current_user)):	
				?>
				<div class="large-5 medium-7 small-7 columns text-right menu-usuario">
					<!-- CARD -->
					<div class="medium-4 columns hide-for-small">&nbsp;</div>
					<div class="medium-2 columns logo-usuario hide-for-small">
						<?//=$this->Html->image('cliente/logo_cliente.png', array('alt' => 'TalkingHUB'));?>
					</div>
					
					<div class="medium-4 columns text-left hide-for-small">
						<ul class="vcard">
							 <li class="fn"><?=$current_user['name'];?></li>
							 <li>
								 <?php
								 	echo 'Administrador';
								 ?>
							 </li>
						</ul>
					</div>
					<div class="small-8 columns text-right show-for-small">
						<ul class="vcard">
							 <li class="fn"><?=$current_user['name'];?></li>
						</ul>
					</div>
					<!-- END CARD -->
					
					
					<!-- DROP DOWN OPTION -->
					<div class="medium-2 small-4 columns drop-options">
						<a href="javascript:void(0);" data-dropdown="opcoesusuario">
							<?= $this->Html->image('seta_drop_list.png', array('width' => '20', 'height' => '12'));?>
						</a>
					</div>
						<ul id="opcoesusuario" class="f-dropdown text-center" data-dropdown-content>
							<li><?=$this->Html->link('Editar meus dados', array('controller' => 'user', 'action' => 'edit', $current_user['id']))?></li>
							<li><?=$this->Html->link('Listar usuários', array('controller' => 'user', 'action' => 'index'))?></li>
							<li><?=$this->Html->link('Configurações', array('controller' => 'configuracoes', 'action' => 'index'))?></li>
							<li><?=$this->Html->link('Sair', array('controller' => 'user', 'action' => 'logout'))?></li>
						</ul>
					<!-- END DROP DOWN OPTION -->
				</div>
				<?php
			endif;
			?>
			<!--- END USER ACCESS --->
			
			
			
			
		</div>
		<!-- End Header and Nav -->
		
		
		
		
		
		<!-- Sub Header -->
		<div class="row talkinghub-sub-header">
			<hr>
		</div>
		<!-- End Sub Header -->
		
		<div class="row">
			<div class="small-12 columns">&nbsp;</div>
		</div>
		
		
		<!-- CONTENT -->
		<div class="row">
			<!-- MENU LATERAL -->
			<?php
			echo $this->element('admin_menu');
			?>
			<!-- END MENU LATERAL -->
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!-- GRID -->
			<div class="medium-9 columns talkinghub-content">
				
				
				<?php 
				echo $this->Session->flash();
				
				echo $this->fetch('content'); 
				?>
				
				
				
			
			</div>
			<!-- END GRID -->
			
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
		echo $this->Html->script('ordenar.js');
		echo $this->Html->script('ajaxupload.3.5.js');
		?>
		<script>
			$(document).foundation();
			
			tinymce.init({
				selector: "textarea",
				language : 'pt_BR',
				paste_text_sticky : true,//retira a formatação
				plugins : 'advlist autolink link image lists charmap preview media code',
				relative_urls: false,
				remove_script_host: false
			});
		</script>
		<?php
		echo $this->fetch('script'); 
		// echo $this->element('sql_dump'); 
		?>
	</body>
</html>
