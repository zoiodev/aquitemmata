<?php
	App::uses('AppController', 'Controller');
	App::uses('Folder', 'Utility');
	App::uses('File',  'Utility');

class SobreController extends AppController {
	public $name 	= 'Sobre';
	public $helpers = array('Html', 'Session', 'Paginator');
	public $uses 	= array('User');

	public $paginate = array(
		'limit' => 10,
	);


	function beforeFilter() {
		parent::beforeFilter();
	}

	public function index() {
		$jsonNameSemExt = 'Sobre';
		$requestData = $this->recuperarInfoJson($jsonNameSemExt);

		$this->set('contentComoFunciona', $requestData);
	}


	///// SOS ADMIN
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////

	public function sos_admin_index() {
		$formatJson = '';
		$nomeJsonSemExt = 'sobre';
		$redirectAfterSave = '';

		if($this->request->is('post')){
			$redirectAfterSave = 'index';
			$formatJson = '{
								"titulo": "'.$this->request->data["Sobre"]["titulo"].'",
			    				"txt": "'.preg_replace( "/\r|\n/", "", nl2br($this->request->data["Sobre"]["txt"])).'"
			    			}';

		}

		$jsonLeitura = $this->sos_admin_leituraAndEditJson($nomeJsonSemExt,$formatJson, $redirectAfterSave);

		$this->set('contentSobre', $jsonLeitura);

	}



}
