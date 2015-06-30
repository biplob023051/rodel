<?php

class Question extends AppModel {

	var $name = 'Question';
	
	public $hasMany = array(
        'QuestionTopic' => array(
            'className' => 'QuestionTopic',
			'foreignKey'=>'question_id'
        ),
		'QuestionDomain' => array(
            'className' => 'QuestionDomain',
			'foreignKey'=>'domain_id'
        ),
		'QuestionGrade' => array(
            'className' => 'QuestionGrade',
			'foreignKey'=>'grade_id'
        )
		
    );

		

}

?>