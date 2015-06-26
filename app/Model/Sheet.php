<?php
class Sheet extends AppModel {
		
	//admin or mathspecialist has many sheets
	public $hasMany = array(
        'SheetPage' => array(
            'className' => 'SheetPage',
            'foreignKey' => 'sheet_id',
            'dependent' => false
        )
    );

	//teacher has one sheet
    public $hasOne = array(
        'TeacherPage' => array(
            'className' => 'SheetPage',
            'foreignKey' => 'sheet_id',
            'conditions' => array('Sheet.type' => 'teacher'),
            'dependent' => false
        )
    );		
}
?>