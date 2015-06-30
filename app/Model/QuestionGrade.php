<?php

class QuestionGrade extends AppModel {

	var $name = 'QuestionGrade';
	
	public $belongsTo = array(
        'Question' => array(
            'className' => 'Question',
			'foreignKey'=>'question_id'
        ),
		'GradeLevel' => array(
            'className' => 'GradeLevel',
			'foreignKey'=>'grade_id'
        )
		
    );

		

}

?>