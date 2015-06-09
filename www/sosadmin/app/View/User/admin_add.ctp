<?php
	echo $this->element('validacao_senha_forte');
?>
<div class="medium-9 columns">

	<div class="row titulo-grid">
		<div class="small-12 columns">
			<h4>Criar Usuário</h4>
			<div class='bt_voltar' onclick='window.history.back();'>
				<div class='img'></div>
				<p>VOLTAR</p>
			</div>
		</div>
	</div>
	<div class="row grid-geral" id="gridTema">
		<div  class="small-12 columns">
			
			
			<?= $this->Form->create($model, array('type'=>'file', 'data-abide' => ''));?>
				
				<div class="row">
					<div class="small-12 columns">
						<div class="name-field">
							<?=$this->Form->input('name', $options = array(
																			'label' => 'Nome',
																			'div' => false, 
																		));?>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="small-12 columns">
						<div class="username-field">
							<?=$this->Form->input('username', $options = array(
																			'label' => 'Username',
																			'div' => false, 
																			'disable' => true,
																			'after' => 'Informe o nome de usuário que utilizará para logar',
																		));?>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="small-12 columns">
						<div class="password-field">
							<?=$this->Form->input('password', $options = array(
																			'type' => 'password',
																			'pattern' => '[a-zA-Z0-9]+',
																			'label' => 'Senha',
																			'id' => 'senha_1', 
																			'onkeyup' => 'passwordStrength(this.value);',
																			//'required' => false,
																			'div' => false, 
																		));?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<div class="password-field">
							<?=$this->Form->input('password_verify', $options = array(
																					'label' => 'Confirmação de Senha', 
																					'id' => 'senha_2', 
																					'onblur' => 'passwordVerify(this.value);',
																					'type' => 'password',
																					'pattern' => '[a-zA-Z0-9]+',
																					'required' => false,
																					'div' => false, 
																				));?>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns alinhamento-div-verificacao">
						<!-- <div style="margin-top:-30px;"> -->
		                	
								<label for="passwordStrength">Verificação de senha forte:</label>
								<div class="holder-meter">
									<div id="passwordStrength" class="strength0"></div>
								</div>
								<div id="passwordDescription">Senha não informada</div>
								<!-- <meter id="mtSenha"> -->
							
		                <!-- </div> -->
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns">
						<div class="email-field">
							<?=$this->Form->input('email', $options = array(
																			'label' => 'E-mail',
																			'div' => false, 
																		));?>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns">
						<div class="email-field">
							<?php
				                echo $this->Form->input('role_id', array(
				                     //'name' => 'data[User][role_id]',
									 'label' => 'Nível de permissão',
				                     'type' => 'select',
				                     'options' => $rolesAll,
				                     //'selected' => $this->data['User']['role_id']
				                ));
							?>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="small-12 columns">
						<?=$this->Form->input('Salvar', $options = array(
																		'type' => 'submit',
																		'label' => false,
																		'div' => false, 
																		'class' => 'button radius',
																	));?>
					</div>
				</div>
			<?=$this->Form->end();?>
				
			
		</div>
	</div>
</div>