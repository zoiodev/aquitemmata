<!-- A barra lateral da direita -->
	<div class="sb-slidebar sb-right sb-width-custom" data-sb-width="30%">
		<ul>
			<li>
				<a href="<?=$this->Html->url(array(
													'controller' => 'index',
													'action' => 'index',
													'sos_admin' => true
													))?>"
					class="<?php if($this->params['controller'] == 'index'){echo 'active';} ?>">
					Home
				</a>
			</li>
			<li>
				<a href="<?=$this->Html->url(array(
													'controller' => 'comoFunciona',
													'action' => 'index',
													'sos_admin' => true
													))?>"
					class="<?php if($this->params['controller'] == 'comoFunciona'){echo 'active';} ?>">
					Como Funciona
				</a>
			</li>
			<li>
				<a href="<?=$this->Html->url(array(
													'controller' => 'TermoDeUso',
													'action' => 'index',
													'sos_admin' => true
													))?>"
					class="<?php if($this->params['controller'] == 'TermoDeUso'){echo 'active';} ?>">
					Termo de Uso
				</a>
			</li>
			<li>
				<a href="<?=$this->Html->url(array(
													'controller' => 'sobre',
													'action' => 'index',
													'sos_admin' => true
													))?>"
													class="<?php if($this->params['controller'] == 'sobre'){echo 'active';} ?>">
					Sobre
				</a>
			</li>
			<li>
				<?=$this->Html->link('Sair', array('controller' => 'user', 'action' => 'logout'))?>
			</li>
		</ul>
	</div>
