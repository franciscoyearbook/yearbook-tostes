<?php
class ParticipantesController extends AppController {
	public $name = 'Participantes';

	public $helpers = array('Html','Form');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login','add', 'index', 'detail', 'retrieveOriginalImage', 'retrieveThumbnail');
	}

	public function index() {
		$this->set ( 'participantes', $this->Participante->find ( 'all'));
	}
	
	public function search(){
		$nome = $this->request->data['Participante']['nomeCompleto'];
		
		if (empty($nome)){
			return $this->redirect ( array (
					'action' => 'index'
			) );
		}
		$participantes = $this->Participante->find('all', array(
				'conditions' => array('Participante.nomeCompleto like ' => "%$nome%")
		));
		
		$this->set('participantes', $participantes);
		$total = count($participantes);
		$msg = $total == 0 ? 'Nenhum participante encontrado' : ($total == 1 ? 'Um participante encontrado' : $total." participantes encontrados");
		$opts = $total == 0 ? array ('class' => 'alert alert-warning') : array ('class' => 'alert alert-info');
		$this->Session->setFlash($msg,'default', $opts);
		$this->render('index');
	}
	
	public function home(){
		$participanteLogado = $this->findParticipanteByLogin($this->getLoggedUserLogin());
		$vistosRecentemente = $this->Participante->find ( 'all', array('conditions' => array('Participante.login' => array_values($this->getLoggedUserLoginsVisitados()))));
		$conterraneos = $this->Participante->find ( 'all', array('conditions' => array('Participante.cidade = ' => $this->getLoggedUserCidade(),'Participante.login != ' => $this->getLoggedUserLogin()) ));
		$this->set('participante', $participanteLogado);
		$this->set('conterraneos', $conterraneos);
		$this->set('vistosRecentemente', $vistosRecentemente);
	}
	
	public function detail($loginParticipante){
		$participante = $this->findParticipanteByLogin($loginParticipante);
		$this->set('participante', $participante);
		if ($participante){
			$this->updateSessionParticipanteVisitados($loginParticipante);
		}
	}
	
	public function add($login = null) {
		$isEditForm = false;
		if ($login != null && empty($this->request->data)) {
			$this->request->data = $this->findParticipanteByLogin($login);
		}
		$this->set('estados', $this->listarEstados());
		if ($this->isFormSubmission()) {
			$this->Participante->create ();
			$newFile = null;
			if ($this->isAddFormSubmission()){
				$newFile = $this->moveTemporaryFile($this->request->data['File']['image']);
			} else if ($this->isEditFormSubmission()){
				if (isset($this->request->data['File']) && !empty($this->request->data['File']['image']['tmp_name'])){
					$newFile = $this->moveTemporaryFile($this->request->data['File']['image']);
				}
			}
			if ($newFile != null){
				$this->Participante->set('arquivoFoto', $newFile);
			}
			if ($this->Participante->save ( $this->request->data )) {
				if ($this->isEditFormSubmission()){
					$this->Session->setFlash ( __ ( 'Dados do participante atualizados com sucesso' ), 'default', array ('class' => 'alert alert-info') );
					$this->updateSession($this->request->data['Participante']['nomeCompleto'], $this->request->data['Participante']['cidade']);
					return $this->redirect ( array (
							'action' => 'home' 
					) );
				} else {
					$this->Session->setFlash ( __ ( 'Novo participante cadastrado com sucesso' ), 'default', array ('class' => 'alert alert-info') );
					return $this->redirect ( array (
							'action' => 'index' 
					) );
				}
			}
			$this->Session->setFlash ( __ ( 'Participante não pode ser incluído. Por favor, tente novamente.' ), 'default', array ('class' => 'alert alert-warning') );
		} else {
			if ($login != null){
				if (!$this->isLoggedUser($login)){
					throw new Exception('Erro, você não pode alterar os dados de outro participante.');
					die();
				}
				$this->request->data = $this->findParticipanteByLogin($login);
				$isEditForm = true;
			}
		}
		$this->set('isEditForm', $isEditForm);
	}
	private function isAddFormSubmission(){
		return $this->request->is ( 'post' );
	}
	private function isEditFormSubmission(){
		return $this->request->is ( 'put' );
	}
	private function isFormSubmission(){
		return $this->request->is ( 'post' ) || $this->request->is ( 'put' );
	}
	public function delete($login){
		if ($this->isLoggedUser($login)){
			$this->Participante->delete($login);
			$this->Session->setFlash ( __ ( 'Participante removido com sucesso.' ), 'default', array ('class' => 'alert alert-info') );
			return $this->redirect ( array (
					'action' => 'logout'
			) );
		} else {
			throw new Exception('Erro, você não pode deletar dados de outro participante.');
			die();
		}
	}	
	private function isLoggedUser($login){
		if ($login == null){
			return false;
		}
		return $this->getLoggedUserLogin() == $login;
	}
	private function getLoggedUserLogin(){
		return $this->Session->read('Participante.login');
	}
	private function getLoggedUserCidade(){
		return $this->Session->read('Participante.cidade');
	}
	
	private function listarEstados(){
		$this->loadModel('Estado');
		return $this->Estado->find('list', array('fields' => array('Estado.idEstado', 'Estado.nomeEstado')));
	}
	
	private function moveTemporaryFile($fileData){
		$uploads_dir = 'uploads';
		if (!file_exists($uploads_dir)) {
			mkdir($uploads_dir, 0755, true);
		}
		$tmp_name = $fileData["tmp_name"];
		$name = $fileData["name"];
		$newFile = "$uploads_dir/$name";
		
		$image = $this->createThumbnail($tmp_name, 400);
		if ($image != null){
			imagejpeg($image, $newFile);
		} else {
			move_uploaded_file($tmp_name, $newFile);
		}
		return $newFile;
	}
	
	public function login() {
		if ($this->request->is ( 'post' )) {
			if ($this->Auth->login ()) {
				$this->createSessionVariables();
				return $this->redirect ( $this->Auth->redirectUrl () );
			} else {
				$this->Session->setFlash ( __ ( 'Login e/ou senha incorretos' ), 'default', array ('class' => 'alert alert-danger'), 'auth' );
			}
		}
	}
	private function createSessionVariables(){
		$loginParticipante = $this->request->data['Participante']['login'];
		$participante = $this->findParticipanteByLogin($loginParticipante);
		$this->updateSession($participante['Participante']['nomeCompleto'], $participante['Participante']['cidade']);
		$this->Session->write('Participante.login', $participante['Participante']['login']);
	}
	
	function updateSessionParticipanteVisitados($loginVisitado){
		$HISTORY_SIZE = 5;
		if ($loginVisitado == $this->getLoggedUserLogin()){
			return;
		}
		$arrayVisitados = $this->getLoggedUserLoginsVisitados();
		if (!is_array($arrayVisitados)){
			$arrayVisitados = array();
		}
		$newArray = array();
		array_push($newArray, $loginVisitado);
		foreach ($arrayVisitados as $outroLogin){
			if (count($newArray) >= $HISTORY_SIZE){
				break;
			}
			if ($outroLogin != $loginVisitado){
				array_push($newArray, $outroLogin);
			}
		}
		$this->Session->write('loginsVisitados', $newArray);
// 		print_r($this->Session->read('loginVisitados'));
// 		die();
	}
	function getLoggedUserLoginsVisitados(){
		if (is_array($this->Session->read('loginsVisitados'))){
			return $this->Session->read('loginsVisitados');
		}
		return array();
	}
	function updateSession($nomeCompleto, $cidade){
		$this->Session->write('Participante.nomeCompleto', $nomeCompleto);
		$this->Session->write('Participante.cidade', $cidade);
	}
	
	private function findParticipanteByLogin($loginParticipante){
		return $this->findParticipanteByLoginJoiningCidadeAndEstado($loginParticipante);
	}
	
	private function findParticipanteByLoginJoiningCidadeAndEstado($loginParticipante){
		$this->Participante->Behaviors->load('Containable');
		return $this->Participante->find('first', array(
				'conditions' => array('Participante.login' => $loginParticipante),
				'contain' => array(
					'Cidade' => array('Estado')
				)	
		));
	}
	public function loggedUser(){
		$this->redirect(array('action' => 'detail', $this->Session->read('Participante.login')));
	}
	public function logout() {
		$this->Session->delete('Participante.login');
		$this->Session->delete('Participante.nomeCompleto');
		$this->Session->delete('loginsVisitados');
	    return $this->redirect($this->Auth->logout());
	}
	
	public function retrieveThumbnail($loginParticipante){
		return $this->retrieveImage($loginParticipante, true);
	}

	public function retrieveOriginalImage($loginParticipante){
		return $this->retrieveImage($loginParticipante, false);
	}
	
	private function retrieveImage($loginParticipante, $generateThumbnail = false){
 		$this->autoRender = false;
 		$this->layout = false;
 		$this->response->type('jpg');
		
 		header('Content-Type: image/jpeg');
		
		$participante = $this->findParticipanteByLogin($loginParticipante);
		
		$imagePath = $participante['Participante']['arquivoFoto'];

		if ($generateThumbnail){
			$image = $this->createThumbnail($imagePath, 100);
			if ($image != null){
				$this->response->body(imagejpeg($image));
			} else {
				$this->response->body(readfile(WWW_ROOT.'/img/'.Configure::read('anonymous-image-name')));
			}
		} else {
			if (!is_file($imagePath)){
				$imagePath = WWW_ROOT.'/img/'.Configure::read('anonymous-image-name');
			}
			$this->response->body(readfile($imagePath));
		}
	}
	
	private function createThumbnail($filename, $maxthumb){
		if (!is_file($filename)){
			return null;
		}
		$size = getimagesize($filename);
		$ratio = $size[0]/$size[1];
		if( $ratio > 1) {
			$width = $maxthumb;
			$height = $maxthumb/$ratio;
		}
		else {
			$width = $maxthumb*$ratio;
			$height = $maxthumb;
		}
		$src = imagecreatefromstring(file_get_contents($filename));
		$dst = imagecreatetruecolor($width,$height);
		imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
		imagedestroy($src);
		return $dst;
	}
}