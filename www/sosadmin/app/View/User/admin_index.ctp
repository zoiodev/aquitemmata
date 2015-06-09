<?php
	//print_r($users);

?>
<div class="small-12 columns">

	<!--- TEMAS -->
	<div class="row titulo-grid">
		<div class="small-7 columns">
			<h4>USUÁRIOS CADASTRADOS</h4>
		</div>
		<div class="small-5 columns">
			<a href="<?=$this->Html->url(array('controller' => 'user', 'action' => 'add'))?>" class="radius button thirdary right tiny bt-talkinghub">Adicionar</a>
		</div>
	</div>
	<div class="row grid-geral" id="gridTema">
		<div  class="small-12 columns">
			<table>
				<thead>
					<tr>
						<th width="10" class="hide-for-small text-center"><?=$this->Paginator->sort('id', 'ID');?></th>
						<th width="400"><?=$this->Paginator->sort('username', 'Usuário');?></th>
						<th class="text-center"><?=$this->Paginator->sort('Role.title', 'Tipo');?></th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($users as $registro):
							?>
						<tr>
							<td class="text-center hide-for-small"><?=$registro[$model]['id']?></td>
							<td><?=$registro[$model]['username']?></td>
							
							<td class="text-center"><?=$registro['Role']['title']?></td>
							
							<td class="bt-acoes text-center">
								<a href="<?=$this->Html->url(array('controller' => 'user', 'action' => 'edit', $registro[$model]['id']))?>" class="radius button action">
									Editar
								</a>
								<?php
								echo $this->Form->postLink('Excluir',
									array('controller' => 'user', 'action' => 'admin_delete', $registro[$model]['id']),
									array('confirm' => 'Tem certeza que deseja excluir este Usuário?', 'class' => 'radius button action')
								);
								?>
								<!-- END BOTOES DE ACAO -->
							</td>
						</tr>
						<?php
					endforeach;
					?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- END TEMAS -->
	<div class="page_selector text-center">
				<?php
                    echo $this->Paginator->prev(
                                                'PÁGINA ANTERIOR',
                                                null,
                                                null,
                                                array('id' => 'last')
                                                );
               
               		 echo $this->Paginator->numbers(array(
                           							 'separator' => '',
                           							 'currentTag' => 'a',
                           							 'tag' => 'div',
                           							 'class' => 'bt'

						                            ));

                	echo $this->Paginator->next(
                                            'PRÓXIMA PÁGINA',
                                            null,
                                            null,
                                            array('id' => 'next')
                                            );
                ?>
	</div>
</div>