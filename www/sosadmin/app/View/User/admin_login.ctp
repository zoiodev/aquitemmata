<?php
//print_r($schemaTable);
$this->start('script');
	//echo $this->Html->script('ajaxupload.3.5.js');
	/*
?>
	<script>
	$(document).ready(function(){
		$('#formlogin').on('invalid', function () {
				var invalid_fields = $(this).find('[data-invalid]');
				console.log(invalid_fields);
				//alert(invalid_fields);
			})
			.on('valid', function () {
				console.log('valid!');
			});
	});
	</script>
	<?php
*/
$this->end();
?>
<!doctype html>
		
	<div class="large-8 medium-11 small-12 medium-centered columns">
		<!-- Header and Nav -->
		<div class="row talkinghub-header">
			<div class="medium-3 small-5 columns">
				<h1><?=$this->Html->image('zoio.png', array('alt' => 'Agência Zoio'))?></h1>
			</div>
			
		</div>
		<!-- End Header and Nav -->
		
		
		
		
		
		<!-- Sub Header -->
		<div class="row talkinghub-sub-header">
			<div class="row sub-header-content">
				<div class="small-12 columns">
					<?php 
					echo $this->Form->create('User', array('data-abide' => '', )); //'class' => 'row espaco-topo'
						?>
						<!-- <div class="row espaco-topo"></div> -->
						
						<!-- <div class="row"> -->
							<!-- Logo do aplicativo -->
							<div class="medium-6 small-6 small-centered medium-uncentered columns text-center">
								<?=$this->Html->image('http://placehold.it/250x250&text=[logo do cliente]', array('class' => 'logo-cliente-login'))?>

							</div>
							<!-- End Logo do Aplicativo -->
	
							<!-- Ações do aplicativo -->
							<div class="medium-6 small-12 columns">
								
								<div class="row">
								<!-- <div class="row login"> -->
									<div class="small-12 columns">
										<div class="small-12 columns hide-for-small">
											<p><br></p>
										</div>
										<?= $this->Form->input('username' ,  array(
														'label' => 'Login', 
														'div' => false,
														'class' => 'login',
													)); ?>

									
													<?= $this->Form->input('password' ,  array(
														'type' => 'password',
														'pattern' => '[a-zA-Z]+',
														'label' => 'Senha', 
														'div' => false,
														'id' => 'senha',
													)); ?>
									</div>
								</div>
								
								<div class="row">
									<!-- Botão criar novo aplicativo -->
									<div class="medium-5 small-12 end columns">
										<?= $this->Form->button('Entrar' ,  array(
															'label' => 'Entrar',
															'type' => 'submit', 
															'div' => true,
															'class' => 'radius button expand',
														)); ?>
													
		
									</div>
									<!-- End Botão criar novo aplicativo -->
								
								</div>
								
							</div>
							<!-- End Ações do aplicativo -->
							
	
							
						<!-- </div> -->
						<?php
					echo $this->Form->end;
					?>
					
					<!-- Seta para Logo -->
					<div class="row">
						<div class="medium-3 small-4 columns">
							&nbsp;
						</div>
					</div>
					<!-- End Seta para Logo -->
				</div>
			</div>
		</div>
		<!-- End Sub Header -->
		
		<div class="row">
			<div class="small-12 columns">&nbsp;</div>
		</div>
		
	</div>	
		