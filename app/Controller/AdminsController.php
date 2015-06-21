<?php
App::uses('CakeEmail', 'Network/Email');
Class AdminsController extends AppController
{ 
	var $name='Admins';
	 var $components = array('Email');
	public $uses= array('User');
	
	 public function beforeFilter()
    {	
	
		  $this->layout='admin';
		
			
		
    }
	
	public function index($user_type_id='')
	{
	 $this->User->unbindModel(array('hasMany' => array('Sheet'), 'hasOne' => array('TeacherSheet')));	
	 $arrUsers = $this->User->find('all', array('conditions' => array('NOT' => array('User.id' => array(85)))));
	 
		if(!$this->Session->read('user'))
			{
				$this->redirect('/admins/adminLogin');
			}
			
	$this->set('arrUsers',$arrUsers);		
	}	
public function importcs($user_type_id='')
	{

	 $arrUsers = $this->User->find('all', array('conditions' => array('NOT' => array('User.id' => array(85)))));
	 
		if(!$this->Session->read('user'))
			{
				$this->redirect('/admins/adminLogin');
			}
                if(isset($this->request->data)){
                            $gid='';
$tid='';
$did='';
$filename='';
                                    if (is_uploaded_file($_FILES['csvfile']['tmp_name'])) {
                     $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
                     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                   echo $sql="select * from grade_levels where level_name='".$data[3]."'";
                   $gradeExist=$this->User->query($sql);
                   $gcount=sizeof($gradeExist);
                    if($gcount>0){
                $gid=$gradeExist[0]['grade_levels']['id'];
}
      else {
      $sql="insert into grade_levels(level_name) values('".$data[3]."')";
     $this->User->query($sql);
$gid=$this->User->getLastInsertID();
}
 $sql1="select * from topics where topic_name='".$data[6]."' and grade_id='".$gid."'";
                    $topicExist=$this->User->query($sql1);
                    $tcount=sizeof($topicExist);
                    if($tcount>0){
                  $tid=$topicExist[0]['topics']['id'];
}
      else {
      $sql1="insert into topics(grade_id,topic_name) values('".$gid."','".$data[6]."');";
     $this->User->query($sql1);
$tid=$this->User->getLastInsertID();
} 
 $sql2="select * from domains where grade_id='".$gid."' and topic_id='".$tid."'";
                    $domainExist=$this->User->query($sql2);
                     $dcount=sizeof($domainExist);
                    if($dcount>0){
                  $did=$domainExist[0]['domains']['id'];
}
      else {
      $sql2="insert into domains(grade_id,topic_id,domain_name) values('".$gid."','".$tid."','".$data[6]."');";
     $this->User->query($sql2);
$did=$this->User->getLastInsertID();
}      
 $sql3="select * from questions where grade_id='".$gid."' and topic_id='".$tid."' and domain_id='".$did."' and file_name='".$data[0]."'";
                    $figureExist=$this->User->query($sql3);
                    if(sizeof($figureExist)>0){
                 
}
      else {
      $sql4="insert into questions(grade_id,topic_id,domain_id,file_name,answer_key,size,index_no,createt_at) values('".$gid."','".$tid."','".$did."','".$data[0]."','".$data[1]."','".$data[2]."','".$data[5]."','".date('Y-m-d H:i:s')."');";
     $this->User->query($sql4);
}              
    }
    fclose($handle);

}
                                                }
			
	$this->set('arrUsers',$arrUsers);		
	}
public function update($user_type_id='')
	{
		$this->User->unbindModel(array('hasMany' => array('Sheet'), 'hasOne' => array('TeacherSheet')));
           $query = "update users set user_role='".$this->request->data['User']['user_role']."' , activate=1 where id=".$this->request->data['User']['id'];
           $res=$this->User->query($query);
		   $arrUser=$this->User->find('all',array('conditions'=>array("id"=>$this->request->data['User']['id'])));
		   
                    $Email = new CakeEmail();
				    $Email->from(array('info@morgancreativegroup.com' => 'Student Booklet Builder'));
					$Email->to($this->request->data['User']['email']);
					$Email->subject('Account Activated');
					$Email->emailFormat('html');
				
				 $message='Dear '.$arrUser[0]['User']['first_name']." ".$arrUser[0]['User']['last_name'].'<br/>'; 
				$message.="<p>Your account has been activated.</p><p>Login Details are as Follow:</p><p>Username: ".$arrUser[0]['User']['email']."<br/>Password: ".$arrUser[0]['User']['user_password']."</p><br/><br/>Thank you.<br/><br/><font color='#898989'>Rodel Student Booklet Builder Team</font><br/>";
	
				$send=$Email->send($message);
                $this->redirect('/admins/index');
	 		
	}


	public function adminLogin()
	{		
	
	        if($this->Session->read('user'))
			{
				$this->redirect('/admins/index');
			}
			
			
		$this->layout='admin_login';
		
		if($this->Session && $this->Session->check('user'))
		   $this->redirect('/admins/index');	
		
		if($this->request->is('post'))	
		{
			$this->User->unbindModel(array('hasMany' => array('Sheet'), 'hasOne' => array('TeacherSheet')));
		$user = $this->User->find('first',array(
		   'conditions'=>array(
							'User.user_password'=>$this->request->data['password'],
							'User.email'=>$this->request->data['email'],
							'User.user_role'=>'admin'
							)
							)
						);
		
			
			if($user)
			{		
					$this->Session->write('user',$user);
					 $this->redirect('/admins/index');		
			}
			else
			{		   

			   $this->Session->setFlash('invalid Username password');
			   $this->set('flagWrong', '1'); 
	
			
			}
		}	
		
		
	}
	function logout(){
		$this->Session->destroy();
		$this->redirect(array('action'=>'adminLogin'));
	}


	public function companyList($page,$companyid)
	{
	
	    $this->set('smallinfo', 'you can manage your companies Here');
		$this->set('title_for_layout', 'Companies ');
		$this->set('permissions',$permissions);
		//$this->layout='login_layout';


		$str .= 'role="COMPANY"';		

		$Currentuserid=$this->Session->read('user.User.id');

		if(!$page)
			$page=1;	

		
		
			$query = "select count(*) as total from users as a where $str";
			$totalEmp = $this->User->query($query);

			if($totalEmp[0][0]['total']>0)
		   {
				$offset = ($page-1)*1;	
				$totalPages = ceil($totalEmp[0][0]['total']/1);
			
				$query = "select * from users as a join user_profiles as b on a.id=b.user_id where a.id!=$Currentuserid and $str limit ".$offset.", 20";
				$employeeResult = $this->User->query($query);
		   }
		   else
			   $employeeResult =array();


			print_r($employeeResult);exit;
			if(count($employeeResult)>0)
		    {

			  $arrDesignations = $this->Designation->find('all',array("conditions" => array("company_id"=>$companyid)));
			  while(list($key,$val)=each($arrDesignations))
			  {
				$arrDesig[$val['Designation']['id']]=$val['Designation']['designation'];
			  }
			  $this->set('arrDesig',$arrDesig);
		    }

			$this->set('employeeResults', $employeeResult);

			$this->set('totalPages',$totalPages);						
			$this->set('page',$page);	
			$this->set('first_name',$first_name);
			$this->set('last_name',$last_name);
			
			$this->set('email',$email);
			$this->set('city',$city);
			$this->set('phone',$phone);
			
			$multiMarker = $this->UserProfile->find('all');
			$this->set('multiMarker', $multiMarker);
			
	}

}
?>