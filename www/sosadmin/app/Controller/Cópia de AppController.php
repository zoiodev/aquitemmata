<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller', 'Network/Email');


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $uses = array('Configuracao', 'Aplicativo');
	
	public $components = array(
        'Cookie',
        'P28n',
        'Session',
        'Auth' => array(
            // 'loginAction' => array('controller' => 'index', 'action' => 'index'),
            'loginRedirect' => array('controller' => 'index', 'action' => 'index', 'sos_admin' => true),
            'logoutRedirect' => array('controller' => 'user', 'action' => 'login', 'sos_admin' => true),
            // 'loginRedirect' => array('controller' => 'index', 'action' => 'index', 'admin' => false),
            // 'logoutRedirect' => array('controller' => 'user', 'action' => 'login', 'admin' => true),
				
			
            //,'logoutRedirect' => array('controller' => 'index', 'action' => 'xml')
        )
    );

	function beforeFilter(){
		
		$this->Auth->authError = " ";
		
		///===> ADMIN
        if(!empty($this->params['prefix']) && $this->params['prefix'] == 'sos_admin') {

			$this->Auth->deny('*');
			
			
			//echo '['. $this->action .']';

			if ($this->name == 'User') {
				if ($this->action == 'admin_login') {
					$this->layout = 'login';
				} else {
					$this->layout = 'sos_admin';
				}
				
			} else {
				$this->layout = 'sos_admin';
			}
			 
						
			if ($this->Session->read('Auth.User')):
				$this->set('userAdmin', $this->Auth->user('role_id'));
				$this->set('current_user', $this->Session->read('Auth.User'));
				
				
				if ($this->Auth->user('role_id') != 1):
					if ($this->name != 'Index' && $this->action == 'admin_index') {
						$this->redirect(array('controller' => 'index', 'action' => 'index'));
					}
				endif;
				
			endif;




			
		///===> FRONT-END
        } else {

			// $this->Auth->deny('*');
			$this->Auth->allow('*');
			

			///==> Liberar em caso de múltiplos idiomas
			/*
			$lang = $this->Cookie->read('lang');
			$this->set('lang', $lang);
			*/
			
						
        }
	
		
	}
	
	public function configuracoesGerais($fields = null) {
		$parametros = array();
		if ($fields != null):
			$parametros = array(
				'fields' => $fields,
			);
		endif;
		$registro = $this->set('configuracoes', $this->Configuracao->find('first', $parametros));
		
		return $registro;
	}


	public function sendMail($assunto, $mensagem, $email_para = null) {
		
		$dados_envio = $this->configuracoesGerais(array(
													'email_destinatario', 
													'email_remetente_host', 
													'email_remetente', 
													'email_remetente_senha',
												));
		
		//DADOS SMTP
		if (!empty($dados_envio)):
			$smtp 		= $dados_envio['Configuracao']['email_remetente_host'];
			$usuario 	= $dados_envio['Configuracao']['email_remetente'];
			$senha 		= $dados_envio['Configuracao']['email_remetente_senha'];
			if ($email_para == null):
				$email_para = $dados_envio['Configuracao']['email_destinatario'];
			endif;
			
		else:
			$smtp 		= "smtp.zoio.net.br";
			$usuario 	= "tester@zoio.net.br";
			$senha 		= "zoio2010";
			if ($email_para == null):
				$email_para = 'zoiodev@zoio.net.br';
			endif;
		endif;
		
		$email_de = $usuario;
		
		
		
	
		require_once './smtp/smtp.php';
	
		$mail = new SMTP;
		$mail->Delivery('relay');
		$mail->Relay($smtp, $usuario, $senha, 587, 'login', false);
		//$mail->addheader('content-type', 'text/html; charset=utf-8');
		//$mail->addheader('content-type', 'text/html; charset=iso-8859-1');
		$mail->TimeOut(10);
		$mail->Priority('normal');
		$mail->From($email_de);
		$mail->AddTo($email_para);
		//$mail->AddBcc('zoiodev@zoio.net.br');
		$mail->Html($mensagem);
	
		if($mail->Send($assunto)){
			//echo '_SMTP+_Enviou para g......@zoio.net.br';
			return true;
			
		} else {
			//echo '_SMTP+_Não enviou e-mail';
			return false;
			
		}
	}
	


	public function resizeImage($dir, $toResize, $maxW=750, $maxH=540, $force=false) {
		$imagemToResize = $dir.$toResize;
		$ext = ".".end(explode(".", $toResize));
		$error = '';

		if(!$maxH && !$maxW) {
			return true;
		}

		$largura_alvo = $maxW;
		$altura_alvo  = $maxH;

		if($maxW <= $largura_alvo && $maxH <= $altura_alvo && $force=false) {
			return true;
		}

		$file_dimensions = getimagesize($dir.$toResize);
		$fileType = strtolower($file_dimensions['mime']);

		if($fileType=='image/jpeg' || $fileType=='image/jpg' || $fileType=='image/pjpeg') {
			$img = imagecreatefromjpeg($imagemToResize);
		} else if($fileType=='image/png') {
			$img = imagecreatefrompng($imagemToResize);
		} else if($fileType=='image/gif') {
			$img = imagecreatefromgif($imagemToResize);
		}

	   $largura_original = imagesX($img);
	   $altura_original = imagesY($img);

	   $altura_nova = ($altura_original * $largura_alvo)/$largura_original;

	   if($altura_nova>$altura_alvo)
	   {
	      $altura_nova = $altura_alvo;
	      $largura_nova = round(($largura_original * $altura_alvo)/$altura_original);
	      $nova = ImageCreateTrueColor($largura_nova,$altura_alvo);

		  if($fileType=='image/png' || $fileType=='image/gif') {
			  imagealphablending($nova, false);
			  imagesavealpha($nova,true);
			  $transparent = imagecolorallocatealpha($nova, 255, 255, 255, 127);
			  imagefilledrectangle($nova, 0, 0, $largura_nova, $altura_nova, $transparent);
		  }

	      imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura_nova, $altura_nova, $largura_original,  $altura_original);
	   }
	   else
	   {
	      $largura_nova = $largura_alvo;
	      $nova = ImageCreateTrueColor($largura_alvo,$altura_nova);

		  if($fileType=='image/png' || $fileType=='image/gif') {
			  imagealphablending($nova, false);
			  imagesavealpha($nova,true);
			  $transparent = imagecolorallocatealpha($nova, 255, 255, 255, 127);
			  imagefilledrectangle($nova, 0, 0, $largura_alvo, $altura_nova, $transparent);
		  }

	      imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura_alvo, $altura_nova, $largura_original,  $altura_original);
	   }

	   if($force) {
	      $nova = ImageCreateTrueColor($maxW,$maxH);
	      imagecopyresampled($nova, $img, 0, 0, 0, 0, $maxW, $maxH, $largura_original,  $altura_original);
	   }

		if($fileType=='image/jpeg' || $fileType=='image/jpg' || $fileType=='image/pjpeg') {
			if(!imagejpeg($nova, $imagemToResize,100)) $error = true;
		} else if($fileType=='image/png') {
			if(!imagepng($nova, $imagemToResize,0)) $error = true;
		} else if($fileType=='image/gif') {
			if(!imagegif($nova, $imagemToResize)) $error = true;
		}

		if($error) {
			return 'Erro ao redimencionar '.$toResize;
		} else {
			return true;
		}

	}

	public function subirImagem($model = '', $campo = '', $coluna = '', $acao = '', $id = '') {
		
		//print_r($this->$model->info_files[$coluna]['dir']);
		//die();
		
		$nome_imagem = $this->uploadFile(
										$this->$model->info_files[$coluna]['dir'], 
										$this->request->data[$model][$campo], 
										$this->$model->info_files[$coluna]['ext'], 
										$this->$model->info_files[$coluna]['size'], 
										false, 
										"", 
										false, 
										array('action' => $acao, 'id' => $id), 
										true, 
										$this->$model->info_files[$coluna]['th']
									);

		//print_r ($nome_imagem);
		//echo $nome_imagem['1'];
		//die();
		//print_r($this->$model->info_files[$coluna]['dir'].$this->request->data[$model][$campo]['name']);
		
		//return $this->$model->info_files[$coluna]['dir'].$this->request->data[$model][$campo]['name'];
		return $nome_imagem['1'];
	}



	/**
	*
	*       uploadFile()
	*       Alexandre MBroetto - 03-10-2011
	*
	*       $dir   -> Diretório de Destino do arquivo
	*       $file  -> Arquivo
	*       $ext   -> Extensões permitidas para esse arquivo. (Array)
	*       $force -> Se TRUE, força a existência de um arquivo.
	*       $resize-> Chama a funcao resizeImage() se passado como array
	*       $fileName -> Se TRUE, impõe um novo nome ao arquivo.
	*       $toLower -> Se TRUE, força o nome do arquivo a ser minusculo.
	*
	*/
	public function uploadFile($dir, $file, $ext="", $resize=false, $force=false, $fileName="", $createDir = false, $action='', $toLower=true, $createThumb=false) {
	   $extValid = true;
	   $error = false;
	   $errorLine = '';
	   $thumbName = '';
	   $thumbDir = '';

		//die('aaa'.$force);
		//die($file['name']);
		
		if(!is_dir($dir)) {
			if($createDir) {
				mkdir($dir);
			} else {
				$error = true;
				$errorLine = 'Diretorio nao encontrado!';
			}
		} else {
			if($file['name']=='' && !$force) {
				return array(true, '');
			}
		}
		if(!is_dir($dir) && !$force) {die('Diretório não encontrado');}
		
		/*if(!is_dir($dir) && $createDir) {
			mkdir($dir);
		} else if(!is_dir($dir) && !$createDir){
			$error = true;
			$errorLine = 'Diretorio nao encontrado!';
		}*/
		
		/*print_r($file);
		$is_uploaded = is_uploaded_file($file['tmp_name']);
		$success = move_uploaded_file($file['tmp_name'], $dir);
		
		echo $is_uploaded;
		
		if($success) {
			return 'upload';
		} else {
			return 'bosta';
		}*/
		
	   //if($file['size'] <= 5000000) {
	      if($toLower)
	         $fileExt = strToLower(end(explode(".", $file['name'])));
	      else
	         $fileExt = end(explode(".", $file['name']));

	      if($ext) $extValid = in_array($fileExt, $ext);
	
			if($file['name'] && $extValid) {
			
	         $fileTemp = $file['tmp_name'];

	         if($fileName) {
	            $filename = $fileName;
	         } else {
	            if($toLower) $filename = strToLower($file['name']);
	            else         $filename = $file['name'];
	         }
	
			 if(file_exists($dir.$filename)) {
				$fileNameExt = explode('.', $filename);
				$fileExtension = end(explode('.', $filename));
				$newFileName = '';
				
				for($x=0; $x<count($fileNameExt)-1; $x++) {
					$newFileName .= $fileNameExt[$x].'.';
				}
				
				$newFileName = subStr($newFileName, 0, -1);
				
				$filename = $newFileName.'_'.date('dmyHis').'.'.$fileExtension;
			}

			$filename = str_Replace(' ','_',$filename);

			if(!is_uploaded_file($fileTemp)) {
	            $error = true;
	            $errorLine .= "001 Erro ao efetuar upload do arquivo: ".$file["name"]."\n";
	         } else {
	            if(!move_uploaded_file($fileTemp, $dir.$filename)) {
					$error=false;
					$errorLine .= "002 Erro ao efetuar upload do arquivo: {$file[name]}";
				} else {
					
					if($createThumb) {
						
						$thumbDir = $dir.'thumbs/';
						$thumbName = 'th_'.$filename;
						
						if(!is_dir($thumbDir)) {
							mkdir($thumbDir);
						}
						
						
						if(!copy($dir.$filename, $thumbDir.$thumbName)) {
							$error = false;
							$errorLine .= "003 Erro ao criar Thumb: {$filename}";
						} else {
							if($resize['w']!=0 && $resize['h']!=0) {
								$this->resizeImage($thumbDir, $thumbName, $createThumb['width'], $createThumb['height'], true);
							}
						}
					}
					
					
					
				}
	         }
	      } else if($force) {
	         $error = true;
	         $errorLine = "Arquivo para upload nao identificado.";
	      }
	   //} else {
	   //   $error = false;
	   //   $errorLine = "Arquivo excede o tamanho máximo de 10MB";
	   //}
		
		
		if($ext && !$extValid && $file['name']!='') {
			$errorLine = 'Extensao de arquivo nao permitida.';
		}
		
		if($errorLine) {
			$return = array(false, $errorLine);
		} else {
			$return = array(true, $dir.$filename, $thumbDir.$thumbName);
		}

		if(!$error && isSet($resize)) {
			
			if($resize['w']!=0 && $resize['h']!=0) {
				$resizeImage = $this->resizeImage($dir, $filename, $resize['w'], $resize['h'], $resize['force']);
			}
			
			if (!empty($resizeImage)) {
				if($resizeImage!=1) echo $resizeImage;
			}
		}

	   return $return;
	}

	public function getZoioConfig() {
		$zoioConfig = file_get_contents('config/config.zoio');

		return $zoioConfig;
	}
		
	
	public function subirImagemComMedidas($model = '', $campo = '', $coluna = '', $acao = '', $id = '', $w = '', $h = '') {
		$this->$model->info_files[$coluna]['size']['w'] = $w;
		$this->$model->info_files[$coluna]['size']['h'] = $h;
		
		$nome_imagem = $this->uploadFile(
										$this->$model->info_files[$coluna]['dir'], 
										$this->request->data[$model][$campo], 
										$this->$model->info_files[$coluna]['ext'], 
										$this->$model->info_files[$coluna]['size'], 
										false, 
										"", 
										false, 
										array('action' => $acao, 'id' => $id), 
										true, 
										$this->$model->info_files[$coluna]['th']
									);
		
		//print_r ($nome_imagem);
		//echo $nome_imagem['1'];
		//die();
		
		//return $this->$model->info_files[$coluna]['dir'].$this->request->data[$model][$campo]['name'];
		return $nome_imagem['1'];
	}
	


	/*
	public function resizeImage($dir, $toResize, $maxW=750, $maxH=540, $force=false) {
		$imagemToResize = $dir.$toResize;
		$ext_explode = explode(".", $toResize);
		$ext_explode_end = end($ext_explode);
		$ext = ".". $ext_explode_end;
		$error = '';
		
		if(!$maxH && !$maxW) {
			return true;
		}
		
		$largura_alvo = $maxW;
		$altura_alvo  = $maxH;

		if($maxW <= $largura_alvo && $maxH <= $altura_alvo && $force=false) {
			return true;
		}
	
		$file_dimensions = getimagesize($dir.$toResize);
		$fileType = strtolower($file_dimensions['mime']);
		
		
		//echo 'PIPO: '. $fileType;
		
		if($fileType=='image/jpeg' || $fileType=='image/jpg' || $fileType=='image/pjpeg') {
			$img = imagecreatefromjpeg($imagemToResize);
		} else if($fileType=='image/png') {
			$img = imagecreatefrompng($imagemToResize);
		} else if($fileType=='image/gif') {
			$img = imagecreatefromgif($imagemToResize);
		}

	   $largura_original = imagesX($img);
	   $altura_original = imagesY($img);

	   $altura_nova = ($altura_original * $largura_alvo)/$largura_original;

	   if($altura_nova>$altura_alvo)
	   {
	      $altura_nova = $altura_alvo;
	      $largura_nova = round(($largura_original * $altura_alvo)/$altura_original);
	      $nova = ImageCreateTrueColor($largura_nova,$altura_alvo);
		  
		  if($fileType=='image/png' || $fileType=='image/gif') {
			  imagealphablending($nova, false);
			  imagesavealpha($nova,true);
			  $transparent = imagecolorallocatealpha($nova, 255, 255, 255, 127);
			  imagefilledrectangle($nova, 0, 0, $largura_nova, $altura_nova, $transparent);
		  }
		  
	      imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura_nova, $altura_nova, $largura_original,  $altura_original);
	   }
	   else
	   {
	      $largura_nova = $largura_alvo;
	      $nova = ImageCreateTrueColor($largura_alvo,$altura_nova);
		  
		  if($fileType=='image/png' || $fileType=='image/gif') {
			  imagealphablending($nova, false);
			  imagesavealpha($nova,true);
			  $transparent = imagecolorallocatealpha($nova, 255, 255, 255, 127);
			  imagefilledrectangle($nova, 0, 0, $largura_alvo, $altura_nova, $transparent);
		  }
		  
	      imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura_alvo, $altura_nova, $largura_original,  $altura_original);
	   }

	   if($force) {
	      $nova = ImageCreateTrueColor($maxW,$maxH);
	      imagecopyresampled($nova, $img, 0, 0, 0, 0, $maxW, $maxH, $largura_original,  $altura_original);
	   }

		if($fileType=='image/jpeg' || $fileType=='image/jpg' || $fileType=='image/pjpeg') {
			if(!imagejpeg($nova, $imagemToResize,100)) $error = true;
		} else if($fileType=='image/png') {
			if(!imagepng($nova, $imagemToResize,0)) $error = true;
		} else if($fileType=='image/gif') {
			if(!imagegif($nova, $imagemToResize)) $error = true;
		}
		
		if($error) {
			return 'Erro ao redimencionar '.$toResize;
		} else {
			return true;
		}

	}



	public function uploadFile($dir, $file, $ext="", $resize=false, $force=false, $fileName="", $createDir = false, $action='', $toLower=true, $createThumb=false) {
	   $extValid = true;
	   $error = false;
	   $errorLine = '';
	   $thumbName = '';
	   $thumbDir = '';
	   
	   
	   
		
		if(!is_dir($dir)) {
			if($createDir) {
				mkdir($dir);
			} else {
				$error = true;
				$errorLine = '1 - Diretorio nao encontrado!';
			}
		} else {
			if($file =='' && !$force) {
				return array(true, '');
			}
		}
		
	
		if(!is_dir($dir) && !$force) {die('2 - Diretório não encontrado');}    
		 					
		
		
	   //if($file['size'] <= 5000000) {
	 
	      if($toLower)
	         $fileExt = strToLower(end(explode(".", $file['name'])));
	          
	      else
	         $fileExt = end(explode(".", $file['name']));

	      if($ext) $extValid = in_array($fileExt, $ext);
	
			if($file['name'] && $extValid) {
			
	         $fileTemp = $file['tmp_name'];

	         if($fileName) {
	            $filename = $fileName;
	         } else {
	            if($toLower) $filename = strToLower($file['name']);
	            else         $filename = $file['name'];
	         }
	    
	
			 if(file_exists($dir.$filename)) {
				$fileNameExt = explode('.', $filename);
				$fileExtension = end(explode('.', $filename));

				$newFileName = '';
				
				for($x=0; $x<count($fileNameExt)-1; $x++) {
					$newFileName .= $fileNameExt[$x].'.';
				}
				
				$newFileName = subStr($newFileName, 0, -1);
				
				$filename = $newFileName.'_'.date('dmyHis').'.'.$fileExtension;
			}

			$filename = str_Replace(' ','_',$filename);
			

			if(!is_uploaded_file($fileTemp)) {
	            $error = true;
	            $errorLine .= "001 Erro ao efetuar upload do arquivo: ".$file["name"]."\n";
	         } else {
	            if(!move_uploaded_file($fileTemp, $dir.$filename)) {
					$error=false;
					$errorLine .= "002 Erro ao efetuar upload do arquivo: {$file[name]}";
				} else {
					
					
					//echo 'Aqui 1<br><br>';
					//$this->transferFilesWithFTP($file, $dir);
					
					if($createThumb) {
					
						$thumbDir = $dir.'thumbs/';
						$thumbName = 'th_'.$filename;
						
						if(!is_dir($thumbDir)) {
							mkdir($thumbDir);
						}
						
						
						if(!copy($dir.$filename, $thumbDir.$thumbName)) {
							$error = false;
							$errorLine .= "003 Erro ao criar Thumb: {$filename}";
						} else {
							if($resize['w']!=0 && $resize['h']!=0) {
								$this->resizeImage($thumbDir, $thumbName, $createThumb['width'], $createThumb['height'], true);
							}
						}
					}
					
					
					
				}
	         }
	      } else if($force) {
	         $error = true;
	         $errorLine = "Arquivo para upload nao identificado.";
	      }
	   //} else {
	   //   $error = false;
	   //   $errorLine = "Arquivo excede o tamanho máximo de 10MB";
	   //}
		
		
		if($ext && !$extValid && $file['name']!='') {
			$errorLine = 'Extensao de arquivo nao permitida.';
		}
		
		if($errorLine) {
			$return = array(false, $errorLine);
		} else {
			$return = array(true, $dir.$filename, $thumbDir.$thumbName);
		}

		if(!$error && isSet($resize)) {
			
			if($resize['w']!=0 && $resize['h']!=0) {
				$resizeImage = $this->resizeImage($dir, $filename, $resize['w'], $resize['h'], $resize['force']);
			}
			
			if (!empty($resizeImage)) {
				if($resizeImage!=1) echo $resizeImage;
			}
		}

		
		//$this->transferFilesWithFTP($file, $dir);


	   return $return;
	}

		
	public function getZoioConfig() {
		$zoioConfig = file_get_contents('config/config.zoio');
		
		return $zoioConfig;
	}
	*/



		
/*
	public function getZoioConfig() {
		$zoioConfig = file_get_contents('config/config.zoio');
		
		return $zoioConfig;
	}
*/
	
	function limpaTags($limpar) {

        if(is_array($limpar)) {
        	$str = '';

        	for($x=0; $x<count($limpar); $x++) {
        		$str .= ($limpar[$x]!='') ? $limpar[$x].' ' : '';
        	}

        	$str = strip_Tags(str_Replace(" ", ", ", subStr($str, 0, -1)));
        }

        return $str;

    }


    function stringToSlug($str) {
		
		$array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
				 , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
				 
		$array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
				 , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
		
		$str = str_replace( $array1, $array2, $str );
		
		
		/*
		/// ERRO DE CARACTERES NESTA FUNÇÃO //////////////
		//////////////////////////////////////////////////
			$as = array("Ã¡", "Ã£", "Ã ", "Ã¢", "Ã¤","Ã", "Ã", "Ã", "Ã", "Ã");
			$str = str_replace($as, "a", $str);
			
			$es = array("Ã©", "Ãª", "Ã¨", "Ã«","Ã", "Ã", "Ã", "Ã");
			$str = str_replace($es, "e", $str);
			
			$is = array("Ã­", "Ã®", "Ã¬", "Ã¯", "Ã", "Ã", "Ã", "Ã");
			$str = str_replace($is, "i", $str);
			
			$os = array("Ã³", "Ã²", "Ã´", "Ã¶", "Ãµ", "Ã", "Ã", "Ã", "Ã", "Ã");
			$str = str_replace($os,"o", $str);
			
			$us = array("Ãº", "Ã»", "Ã¹", "Ã¼", "Ã", "Ã", "Ã", "Ã");
			$str = str_replace($us,"u", $str);
			
			$ns = array("Ã±", "Ã");
			$str = str_replace($ns, "n", $str);
			
			$cs = array("Ã§", "Ã");
			$str = str_replace($cs, "c", $str);
		*/
		
		$str = strtolower(trim($str));
		//$str = strtr($str, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_");
		$str = ereg_replace("[^a-zA-Z0-9_]", "-", $str);
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		return $str;
    }



	function paginacao($curPage, $numeroDePaginas, $controller, $action = 'index', $addClass = 'paginacaoMargin') {
		$paginacao = "";

		$curPageStyle = 'color:#9ACA3C;border:0px solid #004b7f;';

		$paginacao = ($curPage==1) ? '' : '<a href="'.$this->webroot.$controller.'/'.$action.'" class="'.$addClass.'" rel="1" style="border:0;">Primeira</a>';

		if($numeroDePaginas>5) {
        	$pageMin = ($curPage<=2) ? 1 : ($curPage-2);
        	$pageMax = ($curPage+2);

        	if(($curPage+1) == $numeroDePaginas || $curPage == $numeroDePaginas) {
        		$pageMax = $numeroDePaginas;
        	}

        	for($x=$pageMin; $x<=$pageMax; $x++) {
				$style = '';

				if($x==$curPage) $style=$curPageStyle;

					$y = ($x==1) ? '' : $x;
					$paginacao .= '<a href="'.$this->webroot.$controller.'/'.$action.'/'.$y.'" style="'.$style.'" class="'.$addClass.'" rel="'.$y.'">'.$x.'</a>';
        	}
		} else {
			for($x=1; $x<=$numeroDePaginas; $x++) {
				$style = '';

				if($x==$curPage) $style=$curPageStyle;

				$y = ($x==1) ? '' : $x;
				$paginacao .= '<a href="'.$this->webroot.$controller.'/'.$action.'/'.$y.'" class="'.$addClass.'" style="'.$style.'" rel="'.$y.'">'.$x.'</a>';
			}
		}

		//$paginacao .= ($curPage!=$numeroDePaginas) ? '<a href="'.$this->webroot.$controller.'/'.$action.'/'.$numeroDePaginas.'" class="'.$addClass.'" rel="'.$numeroDePaginas.'">Última</a>' : '';
		$paginacao .= ($curPage!=$numeroDePaginas) ? '<a href="'.$this->webroot.$controller.'/'.$action.'/'.$numeroDePaginas.'" class="'.$addClass.'" rel="'.$numeroDePaginas.'" style="border:0;">Última</a>' : '';

		if($numeroDePaginas==0) $paginacao = "";

		return $paginacao;
    }
	
	
	
	public function validaEmail($email) {
		$conta = "^[a-zA-Z0-9\._-]+@";
		$domino = "[a-zA-Z0-9\._-]+.";
		$extensao = "([a-zA-Z]{2,4})$";
		
		$pattern = $conta.$domino.$extensao;
		
		if (ereg($pattern, $email)):
			return true;
		else:
			return false;
		endif;
	}
	
	function nameImageWithPath($img_path = '') {
		$a_file = explode('/', $img_path);
		
		return end($a_file);
	}
	
	function thumbPath($img_path = '') {
		return str_replace($this->nameImageWithPath($img_path), '/thumbs/th_'. $this->nameImageWithPath($img_path), $img_path);
		
	}
	
	function apagarArquivo($file) {
		if (file_exists($file)) {
			unlink($file);
		}
	}
	
	
	
	
	public function transferFilesWithFTP($file, $dir) {
		//inicio conect ftp 	
		$ftp_server = "200.150.207.78";
		$ftp_user = "jelastic-ftp";
		$ftp_pass = "Jr2tOYdVAG";
		//
		// set up a connection or die
		$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 
		
		// try to login
		if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
			echo "Conectado a $ftp_user@$ftp_server\n <br />";
		} else {
			echo "Couldn't connect as $ftp_user\n";
		}
		//fim conect ftp
		
		// Pasta onde o arquivo vai ser salvo
		$_UP['pasta'] = 'app/webroot/uploads/img/teste/';
		$_UP['caminho_abstoluto'] = 'webroot/ROOT/app/webroot/'. $dir;
		$caminho_abstoluto = '/webroot/ROOT/app/webroot/'. $dir;
		
		// Tamanho máximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024 * 10; // 10Mb
		
		// Array com as extensões permitidas
		$_UP['extensoes'] = array('jpg', 'png', 'gif', 'jpeg');
		
		// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
		$_UP['renomeia'] = false;
		
		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
		
		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($file['error'] != 0) {
			die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$file['error']]);
			exit; // Para a execução do script
		}
		
		// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
		
		// Faz a verificação da extensão do arquivo
		$extensao = strtolower(end(explode('.', $file['name'])));
		if (array_search($extensao, $_UP['extensoes']) === false) {
			echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		
		// Faz a verificação do tamanho do arquivo
		} else if ($_UP['tamanho'] < $file['size']) {
			echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
		
		// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
		} else {
			// Primeiro verifica se deve trocar o nome do arquivo
			if ($_UP['renomeia'] == true) {
				// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
				$nome_final = time().'.jpg'; 
			
			} else {
				// Mantém o nome original do arquivo
				$nome_final = $file['name'];
			}
		
			// Depois verifica se é possível mover o arquivo para a pasta escolhida
			
			/*
			if (move_uploaded_file($file['tmp_name'], $_UP['pasta'] . $nome_final)) {
				// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
				echo "Upload efetuado com sucesso!";
				echo '<br /><a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar ou baixar o arquivo</a>';
				echo '<br />"Descrição do arquivo"';
				echo '<br />"Data de envio '. $data .'"';
				echo '<br />"Hora de envio '. $hora .'"';
				echo '<br />"Nome '. $nome_final .'"' ;
				echo '<br />"Tamanho '. $tamanho .'"';
				echo '<br />"Tipo '. $tipo .'"';
				
			
			} else {
				// Não foi possível fazer o upload, provavelmente a pasta está incorreta
				echo "Não foi possível enviar o arquivo ". $file['tmp_name'] ." [". $file['name'] ."], tente novamente.";
				
			}
			*/
			
			
		}
		
		ftp_pasv($conn_id, true);
		
		echo $caminho_abstoluto.$file['name'] .'<br><br>';
		
		//ftp_put( $conn_id, $caminho_abstoluto.$file['name'], $file['tmp_name'], FTP_ASCII );
		
		
		
		ftp_put( $conn_id, 'webroot/ROOT/app/webroot/uploads/img/teste/'.$file['name'], $file['tmp_name'], FTP_ASCII );
		//echo '<br><br><br>[<br>';
		
		
		echo '<br><br><br>[<br>';
		
		
		/// Listando as pastas do FTP
		//$buff = ftp_rawlist($conn_id, 'webroot/ROOT/app/webroot/uploads/img/galerias/', false);
		//var_dump($buff);
		
		echo '<br>]<br><br><br>';
	
		
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$mensagem = $_POST['mensagem'];
		$local = $_UP['pasta'] . $nome_final;
		$tamanho = $_FILES['arquivo']['size'];
		$tipo = $_FILES['arquivo']['type'];
		$ip = $_SERVER['REMOTE_ADDR']. "\n";
		$data = date("d/m/y");
		$hora = date("H:i:s");
		$log = "Log de envio: $data | Horario: $hora | IP: $ip | Imagen: $nome_final | Tamanho: $tamanho Kbts | Tipo: $tipo | Local: $local | Descrição: $mensagem | Nome: $nome | Email: $email ";
		$fp = fopen("log.txt", "a");
		fputs ($fp, "$log");
		fclose($fp);
		
		
		// close the connection
		ftp_close($conn_id); 

	}


	public function sos_admin_leituraAndEditJson($jsonNomeSemExt=null, $jsonFormat=null, $actionRedirect=null) {
		$path = $_SERVER [ 'DOCUMENT_ROOT' ].$this->webroot.'app/webroot/json/'.$jsonNomeSemExt.'/';//<<< caminho absoluto da pasta
		$dir = new Folder($path);
		$files = $dir->find('.*\.json');//<<< verifica se tem arquivos .json
		$nameFile = $jsonNomeSemExt;
		$seachName = $nameFile.'.json';

		$contentHome = '';//<<< JSON sera setado nesta var
		

		if(!empty($files)):
			foreach ($files as $file){
			    $file = new File($dir->pwd() . DS . $file);
			    
				//>>> caso tenha o arquivo home.json
			    if($file->name == $seachName){
			    	// print_r($this->request);
			    	// die();
			    	if($this->request->is('post')){
			    		//>>> estrutura do JSON
			    		$formatJson = $jsonFormat;
			    		//<<< estrutura do JSON

				    	rename($path.$seachName, $path.'bk/'.$nameFile.'_bk_'.date('Ymd_h\hi\ms\s').'.json');//<<< move e renomeia o arquivo

						$file = new File($path.$seachName, true, 0644);//<<< seta arquivo
					    $contents = $file->read();//<<< abre a leitura
					    $file->write($formatJson);//<<< escreve o json
					    $file->close(); //<<< fecha leitura
					    
			    	}
			    	else{
				    	$file = new File($path.$seachName, true, 0644);//<<< criar arquivo
					    $contents = $file->read();
					    $contentHome = json_decode($contents, true);//<<< leitura do json
					    $file->close(); //<<< fecha leitura
					    
			    	}
			    	if(!empty($actionRedirect)){
					    $this->Session->setFlash(' sucesso!');
						$this->redirect(array('action' => $actionRedirect, 'sos_admin' => true));				    
				    }
			    	
			    }
			}
		else:
			//>>> se não existir o json, apenas cria-lo
			if($this->request->is('post')){
				$file = new File($path.$seachName, true, 0644);//<<< seta arquivo
			    $contents = $file->read();//<<< abre a leitura
			    $file->write($jsonFormat);//<<< escreve o json
			    $file->close(); //<<< fecha leitura

			    $this->Session->setFlash(' sucesso!');
				$this->redirect(array('action' => $actionRedirect, 'sos_admin' => true));
			}
			//<<< se não existir o json, apenas cria-lo
		endif;

		return $contentHome;
	
	}

	public function recuperarInfoJson($jsonNameSemExt=null){
		$path = $_SERVER [ 'DOCUMENT_ROOT' ].$this->webroot.'app/webroot/json/'.$jsonNameSemExt.'/';
		$dir = new Folder($path);
		$files = $dir->find('.*\.json');
		$seachName = $jsonNameSemExt.'.json';
		foreach ($files as $file) {
		    $file = new File($dir->pwd() . DS . $file);
		    
		    //>>> caso tenha o arquivo home.json
		    if($file->name == $seachName){
		    	$file = new File($path.$seachName, true, 0644);//<<< criar arquivo
			    $contents = $file->read();
			    $contentHome = json_decode($contents, true);
			    $file->close(); // Be sure to close the file when you're done
		    }
		    return $contentHome;
		    //<<< caso tenha o arquivo home.json
		}
	
	}
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////
	///// function Created/Modified/Read JSON
	// function sos_admin_function(){
		// $path = $_SERVER [ 'DOCUMENT_ROOT' ].$this->webroot.'app/webroot/json/home/';//<<< caminho absoluto da pasta
		// $dir = new Folder($path);
		// $files = $dir->find('.*\.json');//<<< verifica se tem arquivos .json
		// $nameFile = 'home';
		// $seachName = $nameFile.'.json';

		// $contentHome = '';//<<< JSON sera setado nesta var

		// foreach ($files as $file) {
		//     $file = new File($dir->pwd() . DS . $file);
		    
		// 	//>>> caso tenha o arquivo home.json
		//     if($file->name == $seachName){
		//     	if($this->request->is('post')){
		//     		//>>> estrutura do JSON
		//     		$formatJson = '{
		// 	    				"txt": "'.preg_replace( "/\r|\n/", "", nl2br($this->request->data["HomeText"]["txt"])).'" 
		// 	    			}';
		//     		//<<< estrutura do JSON

		// 	    	rename($path.$seachName, $path.'bk/'.$nameFile.'_bk_'.date('Ymd_h\hi\ms\s').'.json');//<<< move e renomeia o arquivo

		// 			$file = new File($path.$seachName, true, 0644);//<<< seta arquivo
		// 		    $contents = $file->read();//<<< abre a leitura
		// 		    $file->write($formatJson);//<<< escreve o json
		// 		    $file->close(); //<<< fecha leitura
				    
		// 		    $this->Session->setFlash(' sucesso!');
		// 			$this->redirect(array('action' => 'index', 'sos_admin' => true));				    
		//     	}else{
		// 	    	$file = new File($path.$seachName, true, 0644);//<<< criar arquivo
		// 		    $contents = $file->read();
		// 		    $contentHome = json_decode($contents, true);//<<< leitura do json
		// 		    $file->close(); //<<< fecha leitura
		//     	}
		    	
		//     }
		// }

		// $this->set('contentHome', $contentHome);
	// }
	///// function Created/Modified/Read JSON
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////
	
}