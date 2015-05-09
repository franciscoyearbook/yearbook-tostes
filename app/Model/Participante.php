<?php
App::uses ( 'SimplePasswordHasher', 'Controller/Component/Auth' );
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
class Participante extends AppModel {
	public $name = 'Participante';
 	public $primaryKey = 'login';
	
	public $belongsTo = array(
			'Cidade' => array(
					'className' => 'Cidade',
					'foreignKey' => 'cidade'
			)
	);
	
	public $validate = array (
			'nomeCompleto' => array (
					'required' => array (
							'rule' => array (
									'notEmpty'
							),
							'message' => 'Nome Completo é obrigatório'
					)
			),
			'email' => array (
					'required' => array (
							'rule' => array (
									'notEmpty'
							),
							'message' => 'Email é obrigatório'
					)
			),
			'cidade' => array (
					'required' => array (
							'rule' => array (
									'notEmpty'
							),
							'message' => 'Cidade é obrigatória'
					)
			),
			'login' => array (
					'required' => array (
							'rule' => array (
									'notEmpty' 
							),
							'message' => 'Login é obrigatório' 
					) 
			),
			'descricao' => array (
					'required' => array (
							'rule' => array (
									'notEmpty'
							),
							'message' => 'Descrição é obrigatória'
					)
			)
	);

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['login'])) {
			if (!empty($this->data[$this->alias]['senha'])){
				$this->data[$this->alias]['senha'] = AuthComponent::password($this->data[$this->alias]['senha']);
			} else {
				unset($this->data[$this->alias]['senha']);
			}
		}
		return true;
	}
}