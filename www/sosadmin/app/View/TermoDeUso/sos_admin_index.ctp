	<div class="" ng-controller="termoDeUsoController">
		<h1 class="text-center">{{titlePage}}</h1>

		<?=$this->Form->create('TermoDeUso', array('id' => 'formTermoDeUso'));?>
			<br>
			<br>
			<br>

			<label>Insira o Título Lateral
				<?php
				$title = '';
				if(!empty($contentTermoDeUso)){
					$title = $contentTermoDeUso['titulo'];
				}
					echo $this->Form->input('titulo', array(
						'label' => false,
						'placeholder' => 'Seu Título',
						'value' => $title
					));
					?>
			</label>
			<label>Insira o texto de Termo de Uso
				<?php
					$content = '';
					if(!empty($contentTermoDeUso)){
						$content = preg_replace('/\<br(\s*)?\/?\>/i', "\n",$contentTermoDeUso['txt']);
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
