<?php

class QuestionTopic extends AppModel {

	var $name = 'QuestionTopic';
	
	public $belongsTo = array(
        'Question' => array(
            'className' => 'Question',
			'foreignKey'=>'question_id'
        ),
		'Topic' => array(
            'className' => 'Topic',
			'foreignKey'=>'topic_id'
        )
		
    );

		

}

?>