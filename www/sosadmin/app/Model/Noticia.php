<?
class Noticia extends AppModel{
	var $useTable = 'tb_noticias';
	var $name = 'Noticia';


	var $transformUrl = array(
							'url_amigavel' => 'titulo'
						);
	

	public $validate = array(
		'categoria_id' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar a Categoria da notícia',
			)
		),

		'titulo' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar o título',
			)
		),

		'chamada' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar a chamada',
			)
		),
		
		'texto' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar o texto',
			)
		),
	);



	// Informações que serão recuperadas no momento do upload do(s) arquivo(s)
	public $type_files = array(
                            'imagem' => array(
                                                'ext' 	=> array(
                                                                'gif', 
                                                                'jpeg', 
                                                                'png', 
                                                                'jpg',
                                                            ),
                                                'dir' 	=> 'uploads/noticias/',
                                                'size'	=> array('w'=> 400, 'h' => 400, 'force' => false),
                                                'th' 	=> array('width' => 100, 'height' => 100)
                                                )
                        );
	
	public $belongsTo = array(
		'Categoria' => array(
			'className'             => 'Categoria',
			//tabela do relacionamento
			//'joinTable'             => 'tb_conteudo_empresas',
			'foreignKey'            => 'categoria_id',
			//chave de associação
			//'associationForeignKey' => 'id',
			//'fields'				=> array('id', 'nome'),
			'dependent' => true,
		),
	);


	var $order = array("Noticia.id" => "DESC");
	
}
