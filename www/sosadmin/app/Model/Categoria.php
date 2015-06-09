<?
class Categoria extends AppModel{
	var $useTable = 'tb_categorias';
	var $name = 'Categoria';

	public $displayField = 'nome';

	/*
	var $transformUrl = array(
							'url_amigavel' => 'titulo'
						);
	*/

	public $validate = array(
		'nome' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar o nome da Categoria',
			)
		),
	);

	
	public $hasMany = array(
		'Noticia' => array(
			'className'				=> 'Noticia',
			//tabela do relacionamento
			//'joinTable'             => 'tb_conteudo_empresas',
			'foreignKey'            => 'categoria_id',
			//chave de associação
			//'associationForeignKey' => 'id',
			'dependent' => true,
		),
	);

	var $order = array("Categoria.nome" => "ASC");
}