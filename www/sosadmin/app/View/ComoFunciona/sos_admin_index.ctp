	<div class="" ng-controller="comoFuncionaController">
		<h1 class="text-center">{{titlePage}}</h1>

		<?=$this->Form->create('ComoFunciona', array('id' => 'formContato'));?>
		<br>
		<br>
		<br>

			<label>Insira o Título Lateral
				<?php
				$title = '';
				if(!empty($contentComoFunciona)){
					$title = $contentComoFunciona['titulo'];
				}
					echo $this->Form->input('titulo', array(
						'label' => false,
						'placeholder' => 'Seu Título',
						'value' => $title
					));
					?>
			</label>
			<label>Insira o texto de Como Funciona
				<?php
					$content = '';
					if(!empty($contentComoFunciona)){
						$content = preg_replace('/\<br(\s*)?\/?\>/i', "\n",$contentComoFunciona['txt']);
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
