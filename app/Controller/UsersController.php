<?php
App::uses('CakeEmail', 'Network/Email');
Class UsersController extends AppController 
{ 
    var $components = array('Email');
	var $name='Users';  
	public $uses = array('User');
	public function beforeFilter()
	{		
	}
	public function index()
	{
	}
	public function forgetpassword()
	{
         $this->layout='login_layout';
        $existUser = $this->User->findByemail($this->request->data['User']['email']);
       
        if(!$existUser)
			{
                    $this->set('forgetPass',"We couldn't find a Student Booklet Builder account associated with ".$this->request->data['User']['email']);
                        }
        else{
                       $this->set('forgetsuccess',1);
	$Email = new CakeEmail();
				
				$Email->from(array('info@morgancreativegroup.com' => 'Student Booklet Builder'));
					$Email->to($this->request->data['User']['email']);
					$Email->subject('Change password Link');
					$Email->emailFormat('html');
                                      		
				$message='Hi '.$existUser['User']['first_name']." ".$existUser['User']['last_name'].',<br/>'; 
				$message.="<p>To change the password for your Rodel Student Booklet Builder Account, please click on the following link.</br><br/> <a href='http://clientrodel.morgancreativegroup.com/users/changepassword/".$this->request->data['User']['email']."'>http://clientrodel.morgancreativegroup.com/csdcsdfd565sxsdfd4grfgfhghg</a></p><br/>Thank you.<br/><br/><font color='#898989'>Rodel Student Booklet Builder</font><br/>";
	         		$send=$Email->send($message);

}

	}	
public function changepassword($email='')
	{
                    $this->layout='login_layout';                    
                    $this->set('changepass',"1");
                    $this->set('email',$email);
                     if(isset($this->request->data['User']['password'])){
                    $this->User->query("update users set user_password='".$this->request->data['User']['password']."' where email='".$this->request->data['User']['email']."'");
                   $this->set('successpass',"1");
                     $this->set('changepass',"0");
                    $user=$this->User->findByemail($this->request->data['User']['email']);
                              if($user)
			{					
						// Final Array
						if($user['User']['activate']==0){
						$this->set('flagactivate', '1');
						}
						else{
				$this->Session->write('user',$user);
				}
			}
			else
			{		   
			
				$this->set('flagExist', '1'); 
			}
}
                    
    
	}

	public function login()
	{		
		$this->layout='login_layout';
	        $userSessionData=$this->Session->read('user');
                $usersession=$userSessionData['User']['user_role'];
		if($this->Session->check('user') && $usersession!='admin'){
		
			$this->redirect('/users/dashboard');
                         
						}	
		if($this->request->is('post'))
		{								
		    //print_r($this->request->data);exit;
		    $this->User->unbindModel(array('hasMany' => array('Sheet'), 'hasOne' => array('TeacherSheet')));
			$user = $this->User->find('first',array('conditions'=>array('User.user_password'=>$this->request->data['User']['password'],'User.email'=>$this->request->data['User']['email'])));	
			//print_r($user);
			if($user)
			{					
						// Final Array
						if($user['User']['activate']==0){
						$this->set('flagactivate', '1');
						}
						else{
				$this->Session->write('user',$user);
				$this->redirect('/users/dashboard');
				}
			}
			else
			{		   
			
				$this->set('flagExist', '1'); 
			}
		}	
		
		
	}
	
	public function userProfile()
	{	
		$this->layout='company_login_layout';
		$userData = $this->Session->read('user');
		$userDetail = $this->UserProfile->findByUserId($userData['User']['id']);
		$this->set('userDetail',$userDetail);
		if(empty($this->request->data)) {
		    $this->data = $this->UserProfile->read(NULL, $id);
			}
			else {
			 if($this->UserProfile->save($this->data)) {
				   $this->Session->setFlash('The User has been updated');
				   $this->redirect(array('action'=>'userProfile'));
				  }
		}
		
	}
	public function dashboard()
	{	
		$this->layout='math';
		$userData = $this->Session->read('user');
                if(sizeof($userData)>0){
                	// check if form post 
                	if ($this->request->is(array('post','put'))) {
	                	$this->User->Sheet->create();
	                	$this->request->data['Sheet']['user_id'] = $userData['User']['id'];
	                	$this->request->data['Sheet']['type'] = $userData['User']['user_role'];
	                	if ($this->User->Sheet->save($this->request->data)) {
	                		$this->Session->delete('Sheet');
	                		$this->Session->write('Sheet.id', $this->User->Sheet->id);
	                		$this->Session->write('Sheet.name', $this->request->data['Sheet']['name']);
	                	}
	                }
	    if (($userData['User']['user_role'] == 'mathspecialist') || $userData['User']['user_role'] == 'admin') {
	    	$this->User->unbindModel(array('hasOne' => array('TeacherSheet')));
	    } else {
	    	$this->User->unbindModel(array('hasMany' => array('Sheet')));
	    }
		$userDetail = $this->User->find('first',array('conditions'=>array('User.id'=>$userData['User']['id'])));        
                $query="select * from grade_levels";
                $gradeLevel= $this->User->query($query);
             		$this->set('userDetail',$userDetail);
                $this->set('listGrade',$gradeLevel);
		$this->set('selectGrade',"Grade Level");
		$this->set('selectTopics',"Math topics &amp; tips");
                $this->set('selectDomains',"Domains");}
                else{
                    $this->redirect('/');
                    }
		  
	}  
        public function gradelevel()
	{	
		$topics=$this->User->query("select * from topics where grade_id=".$_POST['id']);
                $countvalue=sizeof($topics);                
                if($countvalue>0){
                for($i=0;$i<$countvalue;++$i)
                echo "<li> <a href='#' onclick='domains(".$topics[$i]['topics']['id'].",".$_POST['id'].")"."'>".$topics[$i]['topics']['topic_name']."</a></li>";

}
else{echo "<li><a href='#'>No Topics Found</a></li>";}
		exit;
		  
	}
  public function domains()
	{
		// save domain id on session for future reference
		$this->Session->write('domain_id', $_POST['id']);	
		$questions=$this->User->query("select * from questions where grade_id=".$_POST['gid']." && topic_id=".$_POST['id']." && domain_id=".$_POST['id']);
                $countvalue=sizeof($questions);                
                if($countvalue>0){
               echo '<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">';
                for($i=0;$i<$countvalue;++$i){
                echo "<li id='" . $questions[$i]['questions']['id'] . "' class='ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle'><img src='/img/".$questions[$i]['questions']['file_name']."' alt='quesimg'  class='mCS_img_loaded img1' imgsize='".$questions[$i]['questions']['size']."'><a style='display: none;' href='' src='/img/".$questions[$i]['questions']['file_name']."' title='View larger image' class='ui-icon ui-icon-zoomin'>View larger</a>
    <a style='display: none;' href='link/to/trash/script/when/we/have/js/off' title='Delete this image' class='ui-icon ui-icon-trash'>Delete image</a></li>";
 }
echo "</ul>";
}
else{echo "<li><a href='#'>No Topics Found</a></li>";}
		exit;
		  
	}
public function topics()
	{	
		$domains=$this->User->query("select * from domains where grade_id=".$_POST['gid']." && topic_id=".$_POST['id']);
                $countvalue=sizeof($domains);                
                if($countvalue>0){
                for($i=0;$i<$countvalue;++$i)
                echo "<li> <a href='#' onclick='pics(".$domains[$i]['domains']['id'].",".$_POST['id'].",".$_POST['gid'].")"."'>".$domains[$i]['domains']['domain_name']."</a></li>";

}
else{echo "<li><a href='#'>No Topics Found</a></li>";}
		exit;
		  
	}
	public function checkUsers()
	{	
		
		$userData = $this->Session->read('user');
		
		$userDetail = $this->User->find('first',array('conditions'=>array('User.email'=>$_POST['email'])));
                $countvalue=sizeof($userDetail);
		if($countvalue>0)
		echo 1;
                
		exit;
		
		
		
	}
	public function registration()
	{
		$this->layout='login_layout';
		if($this->request->is('post'))
		{	
		
		   $existUser = $this->User->findByEmail($this->request->data['User']['email']);
		 
			if(!$existUser)
			{	
				
				$this->request->data['User']['activate'] = '0';
				$this->request->data['User']['created_at']=date('Y-m-d H:i:s');
				$this->User->save($this->request->data['User']);
					$this->set('successtxt','Your have successfully registered with the Student Booklet Builder using '.$this->request->data['User']['email'].'. Your account approval may take up 24 hours.');
				$Email = new CakeEmail();
				
				$Email->from(array('info@morgancreativegroup.com' => 'Student Booklet Builder'));
					$Email->to($this->request->data['User']['email']);
					$Email->subject('New Account Details');
					$Email->emailFormat('html');
				
				$message='Hi '.$this->request->data['User']['first_name']." ".$this->request->data['User']['last_name'].',<br/>'; 
				$message.="<p>Your registration has been received and is currently under review. </p><p>A representative will respond back to you within 24 hours.</p><p>You receive a second email upon registration approval.</p><br/>Thank you.<br/><br/><font color='#898989'>Rodel Student Booklet Builder</font><br/>";
	
				$send=$Email->send($message);
			
			}
			else
			{
				$this->set('data',$this->request->data['User']);
				$this->set('message','* Please try another username');
			}	
		}	
	}
	public function add($id='')
	{
		$this->set('title_for_layout', 'Add Employee');
		$permissions = $this->Session->read('user.permissions.'.$this->name);
		$this->set('permissions',$permissions);
		if($this->request->is('post'))
		{	
			if(!$this->request->data['User']['id'])
				{				
					$existUser = $this->User->findByUserName($this->request->data['User']['user_name']);
					$this->set('message', '* Please try another Username');
				}
			else
				{
					$existUser = false;
				}
							
			if(!$existUser)
			{
				if($this->request->data['Designation']['id'])
				{
					$this->request->data['User']['parent_id'] = $this->request->data['User']['parent_id'];
					$this->request->data['User']['role_id'] = $this->request->data['User']['parent_role_id'];
				}
				else
				{
					$this->request->data['User']['role_id'] = $this->request->data['User']['parent_role_id'];
				}

				$this->request->data['User']['company_id'] = $this->Session->read('user.User.id');
				//print_r($this->request->data['UserProfile']);exit;
				$this->User->save($this->request->data['User']);
				$this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'] ? $this->request->data['User']['id'] : $this->User->getLastInsertId();
				$this->UserProfile->save($this->request->data['UserProfile']);
				$this->Session->setFlash('Success!');
				$this->redirect('/Users/view/1');
			}
			else
			{
				$this->set('message','Please Try Another User name');
			}
		}
		else
		{
			if($id)
			{	
				// Find Employee Details
				$employeeDetails = $this->User->findById($id);
				$this->set('employeeDetail',$employeeDetails);
				$userId = $this->Session->read('user.User.id');
				$this->set('userId', $userId);
				if($employeeDetails['User']['parent_id'])
				{
					$selectedRole = $employeeDetails['User']['role_id'];
					$selectedUser = $employeeDetails['User']['parent_id'];
					$selectedCompany = $employeeDetails['User']['company_id'];
					$this->set('selectedCompany',$selectedCompany);
					$this->set('selectedUser',$selectedUser);
				}
				else				
					$selectedRole = $employeeDetails['User']['role_id'];					
					$this->set('selectedRole',$selectedRole);
			}
		}

		if(!$this->Session->read('user.User.role_id'))
		{
			$this->set('sendAjaxCall', true);
			$designationResult = $this->Designation->find('all', array('conditions' => array('company_id' => $this->Session->read('user.User.id'))));
		}		
		else
		{
			$this->set('sendAjaxCall', false);
			$designationResult = $this->Designation->findAllByParentDesignationId($this->Session->read('user.Designation.id'));	
		}	
		 $this->set('arrData', $designationResult);
	}
	
			
	public function delete($id) 
	{		  
		  $this->User->delete($id);		  
		  $this->redirect('/Users/view/1');
	} 		
	public function logOut()
	{
		$this->Session->delete('Sheet');
		$this->Session->delete('user');
		$this->redirect('/');	
	}

	/*
	* Auto save sheet order
	*/
	public function save_order() {
		$this->autoRender = false;
		$this->loadModel('Question');
		// make the param array
		$params = array();
		if (!empty($_REQUEST['items'])) {
			foreach ($_REQUEST['items'] as $key => $value) {
				$question = $this->Question->findById($value);
				$params[$key]['Question']['id'] = $question['Question']['id'];
				$params[$key]['Question']['file_name'] = $question['Question']['file_name'];
				$params[$key]['Question']['size'] = $question['Question']['size'];
			}
			$sheetData['params'] = json_encode($params);
		} else {
			$sheetData['params'] = NULL;
		} 
		// prepare data to save
		$c_user = $this->Session->read('user');
		$sheetData['id'] = $this->Session->read('Sheet.id');
		$sheetData['domain_id'] = $this->Session->read('domain_id');
		$sheetData['type'] = $c_user['User']['user_role'];
		
		if ($this->User->Sheet->save($sheetData)) {
			$response['result'] = 1;
			$response['message'] = __('Page saved successfully.');
 		} else {
 			$response['result'] = 0;
			$response['message'] = __('Page saved failed. Something went wrong.');
		}
		echo json_encode($response);
	}

	/*
	* load save sheet for edit
	*/
	public function ajax_edit_currentsheet() {
		$this->layout = 'ajax';
		$sheet = $this->User->Sheet->findById($this->request->data['id']);
		$this->Session->delete('Sheet');
		$this->Session->write('Sheet.id', $sheet['Sheet']['id']);
		$this->Session->write('Sheet.name', $sheet['Sheet']['name']);
		if (!empty($sheet['Sheet']['params'])) {
			$questions = json_decode($sheet['Sheet']['params'], true);
		} else {
			$questions = array();
		}
		$this->set(compact('questions'));
	}

	/* 
	* load available image list for edit
	*/
	public function ajax_edit_availablesheet() {
		$this->layout = 'ajax';
		$this->loadModel('Domain');
		$domain = $this->Domain->findById($this->Session->read('domain_id'));
		$this->loadModel('Question');
		// get all questions
		$questions = $this->Question->find('all', array(
			'conditions' => array(
				'Question.grade_id' => $domain['Domain']['grade_id'],
				'Question.topic_id' => $domain['Domain']['topic_id'],
				'Question.domain_id' => $domain['Domain']['id']
			),
			'fields' => array('Question.id', 'Question.file_name', 'Question.size')
		)); 

		$sheet = $this->User->Sheet->findById($this->request->data['id']);
		if (!empty($sheet['Sheet']['params'])) {
			$used_questions = json_decode($sheet['Sheet']['params'], true);
			$used_questions = Hash::combine($used_questions,'{n}.Question.id','{n}.Question.id');
		} else {
			$used_questions = array();
		}
		$this->set(compact('questions', 'used_questions'));
	}
	
	
}
?>