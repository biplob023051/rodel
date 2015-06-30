<?php

class Domain extends AppModel {

	var $name = 'Domain';
    
	public $hasMany = array(
        'DomainGrade' => array(
            'className' => 'DomainGrade',
			'foreignKey'=>'domain_id'
        )
    );
	

}

?>