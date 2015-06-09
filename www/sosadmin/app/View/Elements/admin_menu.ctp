<?php
	//print_r($this->params);
	//print_r($this->Session);

if ($this->Session->read('Auth.User')):	

	//echo '['. $userAdmin .']';
	if ($userAdmin < 4):
	//if ($userAdmin == 1):
		?>
		<div class="medium-3 columns menu-lateral">
			
			<a href="<?=$this->Html->url(array(
											'controller' => 'index', 
											'action' => 'index',
											'admin' => true
										));?>" class="radius button secondary <?php if($this->name == 'Index') echo 'active'?>">Home</a>
			<a href="<?=$this->Html->url(array(
											'controller' => 'categorias', 
											'action' => 'index'
										));?>" class="radius button secondary <?php if($this->name == 'Categorias') echo 'active'?>">Categorias</a>
			<a href="<?=$this->Html->url(array(
											'controller' => 'noticias', 
											'action' => 'index'
										));?>" class="radius button secondary <?php if($this->name == 'Noticias') echo 'active'?>">Notícias</a>
		</div>
		<?php
	endif;	
endif;