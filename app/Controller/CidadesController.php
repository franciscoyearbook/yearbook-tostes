<?php
class CidadesController extends AppController {
	public $name = 'Cidades';
	
	public $helpers = array (
			'Html',
			'Form'
	);

	public $components = array('Paginator');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}
	
	function index($id = null) {
		$paginate = array(
				'limit' => 10,
				'order' => array(
						'Cidade.nomeCidade' => 'asc'
				)
		);
		if ($id != null) {
			$paginate['conditions'] = array (
					'Cidade.idEstado =' => $id 
			);
		}
		$this->Paginator->settings = $paginate;
		$this->set ( 'cidades',  $this->Paginator->paginate('Cidade'));
	}
}