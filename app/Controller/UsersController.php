<?php
App::uses('CakeEmail', 'Network/Email');
Class UsersController extends AppController 
{ 
    var $components = array('Email');
	var $name='Users';  
	public $uses = array('User');
	public function beforeFilter() {
        parent::beforeFilter();
        // load all admin template
		$cuser = $this->Session->read('user');
		$this->loadModel('Sheet');
		$this->Sheet->unbindModel(array('hasMany' => array('SheetPage'), 'hasOne' => array('TeacherPage')));
		$templates = array();
		if ($cuser['User']['user_role'] == 'teacher') {
			$templates = $this->Sheet->find('all', array(
				'conditions' => array('Sheet.type' => 'admin', 'Sheet.template' => 'teacher')
			));
		} else {
			$templates = $this->Sheet->find('all', array(
				'conditions' => array('Sheet.type' => 'admin', 'Sheet.template' => $cuser['User']['user_role'])
			));
		}
		$this->set(compact('templates'));
    }
	public function index()
	{
		$this->redirect('/users/dashboard');
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
	public function dashboard($editWorkSheet = null)
	{	
		$userData = $this->Session->read('user');
                if(sizeof($userData)>0){
                	// biplob start
                	if ($userData['User']['user_role'] == 'teacher') {
                		$this->layout='teacher';
                	} else {
                		$this->layout='math';
                	}
                	if ($editWorkSheet) {
						$review_data = $this->Session->read('SheetPage');
						// if session expired
						if (empty($review_data)) {
							$this->Session->delete('Sheet');
							$this->Session->delete('SheetPage');
							return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
						}
						$this->set('questions', json_decode($review_data[0], true));
						$this->set('page_count', count($review_data));
					} else {
						$this->Session->delete('Sheet');
						$this->Session->delete('SheetPage');
					}
					// load all saved sheet
					$this->loadModel('Sheet');
					$this->Sheet->unbindModel(array('hasMany' => array('SheetPage'), 'hasOne' => array('TeacherPage')));
                	// check if form post  
                	if ($this->request->is(array('post','put'))) {
                		// sheet name validation
                		$sheetNameExist = $this->Sheet->find('first', array(
                			'conditions' => array(
                				'Sheet.name' => $this->request->data['Sheet']['name'],
                				'Sheet.user_id' => $userData['User']['id']
                			)
                		));
                		if (!empty($sheetNameExist)) {
                			$this->Session->setFlash(__('You have created a worksheet using the same name, please choose a unique name.'), 'error_form', array(), 'error');
                		} else {
                			$this->Session->write('Sheet.name', $this->request->data['Sheet']['name']);
                		}
	                }	       			
					$sheets = $this->Sheet->find('all', array(
						'conditions' => array('Sheet.user_id' => $userData['User']['id']),
						'fields' => array('Sheet.id', 'Sheet.name')
					));
					$this->set(compact('sheets'));
	                // biplob end
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
		$questions=$this->User->query("select * from questions where grade_id=".$_POST['gid']." && topic_id=".$_POST['tid']." && domain_id=".$_POST['id']);
                $countvalue=sizeof($questions);                
                if($countvalue>0){
               echo '<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">';
                for($i=0;$i<$countvalue;++$i){
                echo "<li id='" . $questions[$i]['questions']['id'] . "' class='ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle'><img src='/img/".$questions[$i]['questions']['file_name']."' alt='quesimg'  class='mCS_img_loaded img1' imgsize='".$questions[$i]['questions']['size']."'><a style='display: none;' href='' src='/img/".$questions[$i]['questions']['file_name']."' title='View larger image' class='ui-icon ui-icon-zoomin'>View larger</a>
    <a style='display: none;' href='link/to/trash/script/when/we/have/js/off' title='Delete this image' class='ui-icon ui-icon-trash'>Delete image</a></li>";
 }
echo "</ul>";
}
else{echo "<li><a href='#'>No Questions Found</a></li>";}
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
			$sheetData = json_encode($params);
		} else {
			$sheetData = NULL;
		}
		$c_user = $this->Session->read('user');
		if ($c_user['User']['user_role'] == 'teacher') {
			$this->Session->write('SheetPage.0', $sheetData);
		} else {
			$this->Session->write('SheetPage.' . $_REQUEST['page_index'], $sheetData);
		}
	}

	/*
	* Math specialist page add
	*/
	public function ajax_page_add() {
		$this->layout = 'ajax';
		$review_data = $this->Session->read('SheetPage');
		if (isset($this->request->data['review'])) {
			$this->set('review', true);
		}
		if (isset($review_data[$this->request->data['page_no']])) {
			$this->set('questions', json_decode($review_data[$this->request->data['page_no']], true));		
		} else {
			$this->set('questions', array());
		}
		
		$this->render('/Elements/users/edit_sheet');
	}

	/*
	* Math specialist page delete
	*/
	public function ajax_page_delete() {
		$this->layout = 'ajax';
		$currentPage = $this->request->data['page_no'];
		$maxPage = $this->request->data['max_page'];

		$this->Session->delete('SheetPage.' . ($currentPage - 1));

		if (($currentPage >= 1) && ($currentPage < $maxPage)) {
          // any page, not one page and not the last page
			$review_data = $this->Session->read('SheetPage');
			$i = 0;
            foreach ($review_data as $key => $value) {
            	$this->Session->write('SheetPage.' . $i, $value);
            	$i++;
            }
            $this->set('questions', json_decode($review_data[$currentPage], true));
        } elseif (($currentPage > 1) && ($currentPage == $maxPage)) {
            // if last page delete
        	$review_data = $this->Session->read('SheetPage');
            $this->set('questions', json_decode($review_data[$currentPage-2], true));
        } else {
        	// if one page and delete
        	$this->set('questions', array());
        }
		$this->render('/Elements/users/edit_sheet');
	}

	/*
	* Teacher page review
	*/
	public function review($template_id = null) {
		$this->layout = 'review';
		$userData = $this->Session->read('user');
		if (empty($template_id)) {
			$review_data = $this->Session->read('SheetPage');
			if (empty($review_data)) {
				return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
			}
			$this->set('questions', json_decode($review_data[0], true));
			$this->set('page_count', count($review_data));
		} else {
			// delete session
			$this->Session->delete('Sheet');
			$this->Session->delete('SheetPage');
			$sheet = $this->Sheet->findById($template_id);
			$this->Session->write('Sheet.name', $sheet['Sheet']['name']);
			if (!empty($sheet['SheetPage'])) {
				foreach ($sheet['SheetPage'] as $key => $value) {
					$this->Session->write('SheetPage.' . $key, $value['params']);
				}
				$this->set('questions', json_decode($sheet['SheetPage'][0]['params'], true));
				if ($sheet['Sheet']['template'] != 'teacher') {
					$this->set('page_count', count($sheet['SheetPage']));
				}
			}
			$this->set('admin_template', true);
		}

		if(sizeof($userData)>0){
			$userDetail = $this->User->find('first',array('conditions'=>array('User.id'=>$userData['User']['id'])));        
			$this->set('userDetail',$userDetail);
			$this->set('selectGrade',"Grade Level");
			$this->set('selectTopics',"Math topics &amp; tips");
			$this->set('selectDomains',"Domains");
		}
	}

	/*
	* Teacher page save
	*/
	public function ajax_savepage(){
		$this->autoRender = false;
		$this->loadModel('Sheet');
		$c_user = $this->Session->read('user');
		$sheetPageData = $this->Session->read('SheetPage');
		if ($this->Session->check('Sheet.id')){
			$sheetData['Sheet']['id'] = $this->Session->read('Sheet.id');
			if ($c_user['User']['user_role'] == 'teacher') {
				$sheetData['TeacherPage']['sheet_id'] = $this->Session->read('Sheet.id');
				$c_sheetPage = $this->Sheet->SheetPage->findBySheetId($sheetData['Sheet']['id']);
				$sheetData['TeacherPage']['id'] = $c_sheetPage['SheetPage']['id'];
			} else {
				$this->Sheet->SheetPage->deleteAll(array('SheetPage.sheet_id' => $sheetData['Sheet']['id']));
			}
		}
		if ($c_user['User']['user_role'] == 'teacher') {
			$sheetData['TeacherPage']['params'] = $sheetPageData[$this->request->data['save_index']];
		} else {
			foreach ($sheetPageData as $key => $value) {
				$sheetData['SheetPage'][$key]['params'] = $value;
			}
		}
		$sheetData['Sheet']['name'] = $this->Session->read('Sheet.name');
		$sheetData['Sheet']['user_id'] = $c_user['User']['id'];
		$sheetData['Sheet']['type'] = $c_user['User']['user_role'];
		$this->Sheet->saveAll($sheetData);
		$this->Session->write('Sheet.id', $this->Sheet->id);
		
	}

	/*
	* Teacher print page
	*/
	public function ajax_printpage() {
		$this->layout = 'ajax';
		$review_data = $this->Session->read('SheetPage');
		if (empty($review_data)) {
			return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
		}
		$c_user = $this->Session->read('user');

		if (!empty($this->request->data['spanish']) && empty($this->request->data['answerkey'])) {
			if ($c_user['User']['user_role'] == 'teacher') {
				$this->set('questions', json_decode($review_data[$this->request->data['save_index']], true));
			} else {
				foreach ($review_data as $key => $value) {
					$all_pages[$key] = json_decode($value, true);
				}
				$this->set(compact('all_pages'));
			}

		} elseif (empty($this->request->data['spanish']) && empty($this->request->data['answerkey'])) {
			if ($c_user['User']['user_role'] == 'teacher') {
				$this->set('questions', json_decode($review_data[$this->request->data['save_index']], true));
			} else {
				foreach ($review_data as $key => $value) {
					$all_pages[$key] = json_decode($value, true);
				}
				$this->set(compact('all_pages'));
			}

		} elseif (!empty($this->request->data['spanish']) && !empty($this->request->data['answerkey'])) {
			if ($c_user['User']['user_role'] == 'teacher') {
				$questions = json_decode($review_data[$this->request->data['save_index']], true);
				$questions = array_merge($questions, $questions);
				$this->set(compact('questions'));
			} else {
				foreach ($review_data as $key => $value) {
					$all_pages[$key] = json_decode($value, true);
				}
				$all_pages = array_merge($all_pages, $all_pages);
				$this->set(compact('all_pages'));
			}
		} else {
			if ($c_user['User']['user_role'] == 'teacher') {
				$this->set('questions', json_decode($review_data[$this->request->data['save_index']], true));
			} else {
				foreach ($review_data as $key => $value) {
					$all_pages[$key] = json_decode($value, true);
				}
				$this->set(compact('all_pages'));
			}
		}
	}

	/*
	* remove order on page delete
	*/
	public function remove_order() {
		$this->autoRender = false;
		$c_user = $this->Session->read('user');
		if ($c_user['User']['user_role'] == 'teacher') {
			$this->Session->delete('Sheet.1.page');
		}
	}


	/*
	* load save sheet for edit
	*/
	public function ajax_edit_currentsheet() {
		$this->layout = 'ajax';
		$this->loadModel('Sheet');
		$c_user = $this->Session->read('user');
		if ($c_user['User']['user_role'] == 'teacher') {
			$this->Sheet->unbindModel(array('hasMany' => array('SheetPage')));
		} else {
			$this->Sheet->unbindModel(array('hasOne' => array('TeacherPage')));
		}
		$sheet = $this->Sheet->findById($this->request->data['id']);
		$this->Session->delete('Sheet');
		$this->Session->delete('SheetPage');
		$this->Session->write('Sheet.id', $sheet['Sheet']['id']);
		$this->Session->write('Sheet.name', $sheet['Sheet']['name']);
		// for teacher
		if (!empty($sheet['TeacherPage']['params'])) {
			$this->Session->write('SheetPage.0', $sheet['TeacherPage']['params']);
			$questions = json_decode($sheet['TeacherPage']['params'], true);
		} elseif (!empty($sheet['SheetPage'])) {
			$questions = json_decode($sheet['SheetPage'][0]['params'], true);
			$this->set('page_count', count($sheet['SheetPage']));
			foreach ($sheet['SheetPage'] as $key => $value) {
				$this->Session->write('SheetPage.' . $key, $value['params']);
			}
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

	/*
	* ajax load grade drop down
	*/
	public function ajax_grades_dropdown() {
		$this->layout = 'ajax';
		$this->loadModel('GradeLevel');
		$query="select * from grade_levels";
        $gradeLevel= $this->User->query($query);
     	$gradeLevels = $this->GradeLevel->find('all');
        $this->set(compact('gradeLevels'));
	}

	/*
	* ajax search by image index no
	*/
	public function ajax_search_image() {
		$this->layout = 'ajax';
		$this->loadModel('Question');
		// get all questions
		$questions = $this->Question->find('all', array(
			'conditions' => array(
				"Question.index_no LIKE" => '%' . $this->request->data['search_index'] . '%',
			),
			'fields' => array('Question.id', 'Question.file_name', 'Question.size')
		));
        $this->set(compact('questions'));
	}
	
	
}
?>