<?php
class User extends AppModel {
	var $name='User';
		
	// admin or mathspecialist has many sheets
	public $hasMany = array(
        'Sheet' => array(
            'className' => 'Sheet',
            'foreignKey' => 'user_id',
            'conditions' => array('OR' => array('Sheet.type' => 'admin', 'Sheet.type' => 'mathspecialist')),
            'dependent' => false
        )
    );

	// teacher has one sheet
    public $hasOne = array(
        'TeacherSheet' => array(
            'className' => 'Sheet',
            'foreignKey' => 'user_id',
            'conditions' => array('TeacherSheet.type' => 'teacher'),
            'dependent' => false
        )
    );		
}
?>