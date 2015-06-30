<?php

class TopicGrade extends AppModel {

	var $name = 'TopicGrade';
	public $belongsTo = array(
        'Topic' => array(
            'className' => 'Topic',
			'foreignKey'=>'topic_id'
        ),
		'GradeLevel' => array(
            'className' => 'GradeLevel',
			'foreignKey'=>'grade_id'
        )
		
    );

}

?>