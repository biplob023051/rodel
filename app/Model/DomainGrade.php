<?php

class DomainGrade extends AppModel {

	var $name = 'DomainGrade';
	public $belongsTo = array(
        'Domain' => array(
            'className' => 'Domain',
			'foreignKey'=>'domain_id'
        ),
		'GradeLevel' => array(
            'className' => 'GradeLevel',
			'foreignKey'=>'grade_id'
        )
		
    );

}

?>