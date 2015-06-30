<?php
class QuestionDomain extends AppModel {

	var $name = 'QuestionDomain';
	
	public $belongsTo = array(
        'Question' => array(
            'className' => 'Question',
			'foreignKey'=>'question_id'
        ),
		'Domain' => array(
            'className' => 'Domain',
			'foreignKey'=>'domain_id'
        )
		
    );

		

}

?>