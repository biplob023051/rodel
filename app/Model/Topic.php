<?php

class Topic extends AppModel {

	var $name = 'Topic';
	
	public $hasMany = array(
        'TopicGrade' => array(
            'className' => 'TopicGrade',
			'foreignKey'=>'topic_id'
        )
    );

	var $validate = array(

	    'topic_name'=>array(

		     'title_must_not_be_blank'=>array(

			      'rule'=>'notEmpty',

				  'message'=>'This Topic is missing a name!'

			 )

		)

	);
	

}

?>