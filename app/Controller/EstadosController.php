<?php
class EstadosController extends AppController {
	public $helpers = array ('Html','Form');
	public $name = 'Estados';
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('listarCidades', 'index');
	}
	
	public function index() {
		$this->set('estados', $this->Estado->find('all'));
	}
	
	public function listarCidades($idEstado){
		$this->layout = null;
		$this->loadModel('Cidade');
		$cidades = $this->Cidade->find('list', array(
				'fields' => array('Cidade.idCidade', 'Cidade.nomeCidade'),
				'conditions' => array (
					'Cidade.idEstado =' => $idEstado
				),
				'order' => array(
						'Cidade.nomeCidade' => 'asc'
				)
		));
		$this->set('cidades', $cidades);
	}
}