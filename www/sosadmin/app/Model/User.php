<?php
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
	public $name = 'usuario';
    //public $actsAs = array('Containable');

     var $belongsTo = array(
		'Role' => array(
			'className'  => 'Role',
		),
       // 'Setor' => array(
       // 		'className' => 'Setor',
       // 	),
     );
    //public $hasMany = array('Loguser');


    /*
	public $hasAndBelongsToMany = array(
		'Setor' => array(
				'className'             => 'Setor',
				//tabela do relacionamento
				'joinTable'             => 'usuarios_setores',
				'foreignKey'            => 'user_id',
				//chave de associação  
				'associationForeignKey' => 'setor_id',
				//'fields'				=> array('id', 'setor'),
		),
	);
	*/

	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar o usuário'
			)
		),
		'password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar a senha'
			)
		),
		'role' => array(
			'valid' => array(
				'rule' => array('inList', array('admin', 'author')),
				'message' => 'Por favor entre com o cargo correto',
				'allowEmpty' => false
			)
		)
	);

	
	public function beforeSave($created) {
		if (!$this->id && !isset($this->data[$this->alias][$this->primaryKey])) {
			// insert
			if (isset($this->data[$this->alias]['password'])) {
				$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
			}
		}
		return true;
	}
	
	
}
