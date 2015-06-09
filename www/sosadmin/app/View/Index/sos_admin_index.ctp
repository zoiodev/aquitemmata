	<div class="" ng-controller="homeController">
		<h1 class="text-center">{{titlePage}}</h1>

		<?=$this->Form->create('HomeText', array('id' => 'formHome'));?>
			<br>
			<br>
			<br>

			<label>Insira o texto da Home
				<?php
					echo $this->Form->textarea('txt', array(
														'placeholder' 	=> 'Digite o texto.',
														'value'			=> preg_replace('/\<br(\s*)?\/?\>/i', "\n",$contentHome['txt'])
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
