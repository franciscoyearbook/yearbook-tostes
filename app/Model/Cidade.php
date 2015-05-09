<?php
class Cidade extends AppModel {
	public $name = 'Cidade';
	public $primaryKey = 'idCidade';
	public $belongsTo = array(
			'Estado' => array(
					'className' => 'Estado',
					'foreignKey' => 'idEstado'
			)
	);
}