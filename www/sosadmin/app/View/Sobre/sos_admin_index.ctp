	<div class="" ng-controller="sobreController">
		<h1 class="text-center">{{titlePage}}</h1>

		<?=$this->Form->create('Sobre', array('id' => 'formSobre'));?>
		<br>
		<br>
		<br>

			<label>Insira o Título Lateral
				<?php
				$title = '';
				if(!empty($contentSobre)){
					$title = $contentSobre['titulo'];
				}
					echo $this->Form->input('titulo', array(
						'label' => false,
						'placeholder' => 'Seu Título',
						'value' => $title
					));
					?>
			</label>
			<label>Insira o texto de Sobre
				<?php
					$content = '';
					if(!empty($contentSobre)){
						$content = preg_replace('/\<br(\s*)?\/?\>/i', "\n",$contentSobre['txt']);
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
