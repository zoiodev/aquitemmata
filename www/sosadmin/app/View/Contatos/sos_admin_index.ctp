	<div class="" ng-controller="contatoController">
		<h1 class="text-center">{{titlePage}}</h1>
		
		<?=$this->Form->create('ContatoText', array('id' => 'formContato'));?>
			<div class="small-12 columns text-right">
				<a href="<?=$this->Html->url(array(
														'controller' => $this->params['controller'],
														'action' => 'index',
														'sos_admin' => false
													))?>">Visualizar {{titlePage}}</a>
				<br>
				<br>
			</div>

			<label>Insira o texto de Contato
				<?php
					$content = '';
					if(!empty($contentHome)){
						$content = preg_replace('/\<br(\s*)?\/?\>/i', "\n",$contentHome['txt']);
					}
					echo $this->Form->textarea('txt', array(
														'placeholder' 	=> 'Digite o texto.',
														'value'			=> $content
													));
					?>
			</label>
			
			<div class="text-center">
				
				<button type="submit" class="button">
					Salvar
				</button>
			</div>
		<?=$this->Form->end();?>
	</div>
	<div class="row">
	</div>
