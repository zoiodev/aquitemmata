<?php
	App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File',  'Utility');

class ContatosController extends AppController {
	public $name 	= 'Contatos';
	public $helpers = array('Html', 'Session', 'Paginator');
	public $uses 	= array('User');
	
	public $paginate = array(
		'limit' => 10,
	);
	
	
	function beforeFilter() {
		parent::beforeFilter();
	}
	
	public function index() {
		$jsonNameSemExt = 'contato';
		$requestData = $this->recuperarInfoJson($jsonNameSemExt);
		
		$this->set('contentHome', $requestData);
	}


	///// SOS ADMIN
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////

	public function sos_admin_index() {
		$formatJson = '';
		$nomeJsonSemExt = 'contato';
		$redirectAfterSave = '';
		
		if($this->request->is('post')){
			$redirectAfterSave = 'index';
			$formatJson = '{
			    				"txt": "'.preg_replace( "/\r|\n/", "", nl2br($this->request->data["ContatoText"]["txt"])).'" 
			    			}';
		}
		
		$jsonLeitura = $this->sos_admin_leituraAndEditJson($nomeJsonSemExt,$formatJson, $redirectAfterSave);
		
		$this->set('contentHome', $jsonLeitura);
		
	}


	
}

