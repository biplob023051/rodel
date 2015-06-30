<?php

	App::uses('CakeEmail', 'Network/Email');

	Class AdminsController extends AppController
	{ 
		var $name='Admins';
		var $components = array('Email');
		public $uses = array('User', 'Domain','Topic','GradeLevel','TopicGrade','DomainGrade','Question','QuestionTopic','QuestionDomain','QuestionGrade');
		
		public function beforeFilter()
		{	
			  $this->layout='admin';
		}
		
		public function index($user_type_id='')
		{
			
		   $arrUsers = $this->User->find('all', array('conditions' => array('NOT' => array('User.id' => array(85)))));
		 
			if(!$this->Session->read('useradmin'))
			{
				$this->redirect('/admins/adminLogin');
			}
			$this->set('listuser','active');
			$this->set('adduser','inactive');			
		    $this->set('useractive','active');					
			$this->set('arrUsers',$arrUsers);		
		}
		
		
	public function addUser($id='')
	{
		$this->set('title_for_layout', 'Add Employee');
		
		$this->set('listuser','inactive');
		if($this->request->is('post'))
		{	
			
			if(!$this->request->data['User']['id'])
			{				
				$existUser = $this->User->findByEmail($this->request->data['User']['email']);
				//$this->set('message', '* Please try another email');
			     $this->request->data['User']['created_at']=date('Y-m-d H:i:s');
				 
			}
			else
			{
				$existUser = false;
			}
							
			if(!$existUser)
			{
				
				$this->User->save($this->request->data['User']);
				if(!$this->request->data['User']['id'])
			    {
					$Email = new CakeEmail();
						$Email->from(array('info@morgancreativegroup.com' => 'Student Booklet Builder'));
						$Email->to($this->request->data['User']['email']);
						$Email->subject('Account Activated');
						$Email->emailFormat('html');
					
					 $message='Dear '.$this->request->data['User']['first_name']." ".$this->request->data['User']['last_name'].'<br/>'; 
					
					$message.="<p>Your account has been activated.</p><p>Login Details are as Follow:</p><p>Username: ".$this->request->data['User']['email']."<br/>Password: ".$this->request->data['User']['user_password']."</p><br/><br/>Thank you.<br/><br/><font color='#898989'>Rodel Student Booklet Builder Team</font><br/>";
		
					//$send=$Email->send($message);
				
				}
				
				$this->Session->setFlash('Success!');
				if(!$this->request->data['User']['id'])
				{			
					$this->redirect('/admins/index');
				}else
				$this->set('message','User updated successfully.');
			}
			else
			{
				$this->set('message1',' Email Already Exist! Please Try Another Email.');
				$this->set('des',$this->request->data);
			}
		}
		
			if($id)
			{	
			
				// Find Employee Details
				$arrUser = $this->User->findById($id);
				$this->set('des',$arrUser);
				
				$selectedRole = $arrUser['User']['role_id'];					
				$this->set('selectedRole',$selectedRole);
			}
		
			$this->set('adduser','active');			
		    $this->set('useractive','active');				
		
	}
	
			
	public function deleteUser($id) 
	{		  
		  $this->User->delete($id);		  
		  $this->redirect('/admins/index');
	} 
		
		
		public function addgrade()
		{

	   	   $this->set('listuser','inactive');
		    $this->set('addgrade','active');			
		    $this->set('gradeactive','active');
			
			if(!$this->Session->read('useradmin'))
				{
					$this->redirect('/admins/adminLogin');
				}
				   
			   if($this->request->data)
			   {
				 $sql="select * from grade_levels where level_name='".$_POST['grade_name']."'";
				 $gradeExist=$this->User->query($sql,false);
				 if(count($gradeExist)>0)
				 {
					$this->set("message1"," Grade Already Exist"); 
				 }
				 else{
						$sql="insert into grade_levels(level_name) values('".$_POST['grade_name']."');";
						$this->User->query($sql,false);
						$this->set("gradeSuccess","Grade Add Successfully"); 
						$this->redirect('/admins/gradelist');
					}
				}
				
		}
		
		public function domains()
		{	
			$domains=$this->User->query("select * from domains where grade_id=".$_POST['gid']." && topic_id=".$_POST['id']);
					$countvalue=sizeof($domains);                
					if($countvalue>0)
					{
						for($i=0;$i<$countvalue;++$i)
								echo "<option value='".$domains[$i]['domains']['id']."'>".$domains[$i]['domains']['domain_name']."</a></option>";
					}
					else{
						echo "<li><a href='#'>No Domains Found</a></li>";
					}
			exit;
			  
		}
		
		public function topics()
		{	
					$topics=$this->User->query("select * from topics where grade_id=".$_POST['id']);
					$countvalue=sizeof($topics);                
					if($countvalue>0){
						for($i=0;$i<$countvalue;++$i)
							echo "<option value='".$topics[$i]['topics']['id']."'> <a href='#' onclick='domains(".$topics[$i]['topics']['id'].",".$_POST['id'].")"."'>".$topics[$i]['topics']['topic_name']."</a></option>";
					}
					else
					{
						echo "<li><a href='#'>No Topics Found</a></li>";
					}
			exit;
			  
		}
		
		public function editgrade($gid='')
		{

		    $this->set('listuser','inactive');
		    $this->set('addgrade','active');			
		    $this->set('gradeactive','active');
			 $this->set('editgradeactive','editactive');
			
			
			  if(!$this->Session->read('useradmin'))
			  {
					$this->redirect('/admins/adminLogin');
			  }
				   
			  if(isset($gid) && !empty($gid))
			  {
				 $sql1="select * from grade_levels where id=".$gid;
				 $gradename=$this->User->query($sql1);
				 
				 $this->set("gradeName",$gradename[0]['grade_levels']['level_name']);
				 $this->set("gradeId",$gid);
			   }
			   if($this->request->data)
			   {
						$sql="update grade_levels set level_name='".$_POST['grade_name']."' where id=".$_POST['grade_id'];
						$this->User->query($sql);
						$this->redirect('/admins/gradelist');
				}
				$this->set("gradeactive",1);
		}
		
		public function deletegrade($gid='')
		{	 
				if(!$this->Session->read('useradmin'))
				{
					$this->redirect('/admins/adminLogin');
				}
				   
				$sql="delete from  grade_levels  where id=".$gid;
				$this->User->query($sql);
				$this->redirect('/admins/gradelist');
		}
		
		public function deletequestions($fid='')
		{	 
				if(!$this->Session->read('useradmin'))
				{
					$this->redirect('/admins/adminLogin');
				}
				   
				$sql="delete from  questions  where id=".$fid;
				$this->User->query($sql,false);
				$this->redirect('/admins/records');
				
		}	

		public function Gradelist()
		{
		
		    $this->set('listgrade','active');			
		    $this->set('gradeactive','active');
			
			$gradelist="select * from grade_levels";
			$gradeList=$this->User->query($gradelist);
		   
			if(!$this->Session->read('useradmin'))
			{
				$this->redirect('/admins/adminLogin');
			}
				
			$this->set('gradeList',$gradeList);		
		}
		
		public function topiclist()
		{
			$topiclist="select * from topics as t join grade_levels as g on  g.id=t.grade_id";
			$topicList=$this->User->query($topiclist);
		
		 
			if(!$this->Session->read('useradmin'))
			{
				$this->redirect('/admins/adminLogin');
			}
			
			$this->set('topicList',$topicList);		
		}
		
		public function Domainlist()
		{
			$domainlist="select * from domains";
			$domainList=$this->User->query($domainlist);
		   
			if(!$this->Session->read('useradmin'))
			{
				$this->redirect('/admins/adminLogin');
			}
			
			$this->set('domainList',$domainList);		
		}
		
		public function importcs($user_type_id='')
		{

			
				if(!$this->Session->read('useradmin'))
				{
					$this->redirect('/admins/adminLogin');
				}
				if(isset($this->request->data))
				{
					$gid='';
					$tid='';
					$did='';
					$filename='';
					if (is_uploaded_file($_FILES['csvfile']['tmp_name'])) 
					{

						 $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
						 $i=0;
						 while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
						 {
						 
							if($i>0){
										$arrgrades=explode(",",$data[3]);
										$arrGradesIds=array();
										while(list($key,$val)=each($arrgrades))
										{
										
											$sql="select * from grade_levels where level_name='".trim($val)."'";
											$gradeExist=$this->User->query($sql,false);
											$gcount=sizeof($gradeExist);
											if($gcount>0){
												$gid=$gradeExist[0]['grade_levels']['id'];
											}
											else {
													
												$datagrade['id']='';
												$datagrade['level_name']=trim($val);
												$this->GradeLevel->Save($datagrade,false);
												$gid=$this->GradeLevel->id;
												
													
											}
											
											$arrGradesIds[]=$gid;
										}
										
										$arrtopics=explode(",",$data[6]);
										$arrTopicIds=array();
										while(list($key,$val)=each($arrtopics))
										{
											$sql1="select * from topics where topic_name='".trim($val)."'";
											$topicExist=$this->User->query($sql1,false);
											$tcount=sizeof($topicExist);
											if($tcount>0)
											{
												$tid=$topicExist[0]['topics']['id'];
											}
											else
											{
												$datatopic['id']='';
												$datatopic['topic_name']=trim($val);
												$this->Topic->Save($datatopic,false);
												$tid=$this->Topic->id;
											}
											reset($arrGradesIds);
											while(list($key1,$val1)=each($arrGradesIds))
											{
												$gid=$val1;
												$arrTopicGrade = $this->TopicGrade->find('first',array('conditions'=>array('topic_id'=>$tid,'grade_id'=>$gid)));
							
												$dataTopicGrade['id']='';
												$dataTopicGrade['topic_id']=$tid;
												$dataTopicGrade['grade_id']=$gid;
												
												if(count($arrTopicGrade)==0)
												{
													 $this->TopicGrade->save($dataTopicGrade,false);
												}
											}
											
											
											$arrTopicIds[]=$tid;
										}
										
										$arrdomains=explode(",",$data[4]);
										$arrDomainIds=array();
										while(list($key,$val)=each($arrdomains))
										{
										
										$sql2="select * from domains where domain_name='".$val."'";
										$domainExist=$this->User->query($sql2,false);
										$dcount=sizeof($domainExist);
										if($dcount>0){
												$did=$domainExist[0]['domains']['id'];
										}
										else {
												
												$datadomain['id']='';
												$datadomain['domain_name']=$val;
												$this->Domain->Save($datadomain,false);
												$did=$this->Domain->id;
											}	
											reset($arrGradesIds);
											while(list($key1,$val1)=each($arrGradesIds))
											{
												$gid=$val1;
												$arrDomainGrade = $this->DomainGrade->find('first',array('conditions'=>array('domain_id'=>$did,'grade_id'=>$gid)));
							
												$dataDomainGrade['id']='';
												$dataDomainGrade['domain_id']=$did;
												$dataDomainGrade['grade_id']=$gid;
												
												if(count($arrTopicGrade)==0)
												{
													 $this->DomainGrade->save($dataDomainGrade,false);
												}
											}
										
											$arrDomainIds[]=$did;
										}											
										
										$sql3="select * from questions where index_no='".trim($data[5])."' and answer_key='".trim($data[1])."'";
										$figureExist=$this->User->query($sql3,false);
										
										if(sizeof($figureExist)==0)
										 {
										 $dataquestion=array();
										 	$dataquestion['id']="";
											$dataquestion['file_name']=trim($data[0]);
											$dataquestion['answer_key']=trim($data[1]);
											$dataquestion['size']=trim($data[2]);
											$dataquestion['index_no']=trim($data[5]);
											$dataquestion['created_at']=date('Y-m-d H:i:s');
											
											$this->Question->Save($dataquestion,false);
											$qid=$this->Question->id;
											
										}
										else	
										{				
											$dataquestion=array();										
											$qid=$figureExist[0]['questions']['id'];
											
											$dataquestion['id']=$qid;
											$dataquestion['file_name']=trim($data[0]);
											$dataquestion['answer_key']=trim($data[1]);
											$dataquestion['size']=trim($data[2]);
											$dataquestion['index_no']=trim($data[5]);
											
											$this->Question->Save($dataquestion,false);
										}
										
										reset($arrGradesIds);
										while(list($key,$val)=each($arrGradesIds))
										{
											$gid=$val;
											$arrQuestionGrade = $this->QuestionGrade->find('first',array('conditions'=>array('grade_id'=>$gid,'question_id'=>$qid)));
							
											$dataQuestionGrade['id']='';
											$dataQuestionGrade['grade_id']=$gid;
											$dataQuestionGrade['question_id']=$qid;
											
											if(count($arrQuestionGrade)==0)
											{
												 $this->QuestionGrade->save($dataQuestionGrade,false);
											}
										}
										
										while(list($key,$val)=each($arrTopicIds))
										{
											$tid=$val;
											$arrQuestionTopic = $this->QuestionTopic->find('first',array('conditions'=>array('topic_id'=>$tid,'question_id'=>$qid)));
							
											$dataQuestionTopic['id']='';
											$dataQuestionTopic['topic_id']=$tid;
											$dataQuestionTopic['question_id']=$qid;
											
											if(count($arrQuestionTopic)==0)
											{
												 $this->QuestionTopic->save($dataQuestionTopic,false);
											}
										}
										
										
										while(list($key,$val)=each($arrDomainIds))
										{
											$tid=$val;
											$arrQuestionDomain = $this->QuestionDomain->find('first',array('conditions'=>array('domain_id'=>$tid,'question_id'=>$qid)));

											$dataQuestionDomain['id']='';
											$dataQuestionDomain['domain_id']=$tid;
											$dataQuestionDomain['question_id']=$qid;
											
											if(count($arrQuestionDomain)==0)
											{
												 $this->QuestionDomain->save($dataQuestionDomain,false);
											}
										}
							
								}
							++$i;            
						}
					$this->set("importsuccess",1);
					fclose($handle);

					}
				}
				
		}
		
		public function update($user_type_id='')
		{
			    $query = "update users set user_role='".$this->request->data['User']['user_role']."' , activate=1 where id=".$this->request->data['User']['id'];
			   $res=$this->User->query($query);
			   
			   $arrUser=$this->User->find('all',array('conditions'=>array("User.id"=>$this->request->data['User']['id'])));
			   
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
		
		public function records($pageid='')
		{
			   if(empty($pageid))
				  $pageid=1;
				  
			   $sql="select count(*) as count from questions";
			   $totalquestions=$this->User->query($sql,false);
			   
			   $count=$totalquestions[0][0]['count'];
			   $this->set('count',$count);
			   
			   $limit=10;
			   $start=($pageid-1)*10;
			   $sqlquery="select * from questions limit ".$start.",".$limit;
			   $questions=$this->User->query($sqlquery,false);
			   $count=count($questions);
			   $i=0;
			   
			   for($i=0;$i<$count;++$i)
			   {                     
						$qid=$questions[$i]['questions']['id'];
						
						$sql="select * from question_topics,topics  where topics.id=question_topics.topic_id and  question_id=$qid";
						$arrTopics=$this->User->query($sql,false);
						$strTopics='';
						while(list($key,$val)=each($arrTopics))
						{
							$strTopics.=$val['topics']['topic_name'].",";
						}
						$strTopics=substr($strTopics,0,-1);
						$questions[$i]['questions']['topic_name']=$strTopics;
						
						
						$sql="select * from question_grades,grade_levels  where grade_levels.id=question_grades.grade_id and question_id=$qid";
						
						$arrgrades=$this->User->query($sql,false);
						$strgrades='';
						while(list($key,$val)=each($arrgrades))
						{
							$strgrades.=$val['grade_levels']['level_name'].",";
						}
						$strgrades=substr($strgrades,0,-1);
						
						$questions[$i]['questions']['grade_name']=$strgrades;
						
						$sql="select * from question_domains,domains  where domains.id=question_domains.domain_id and question_id=$qid";
						$arrdomains=$this->User->query($sql,false);
						$strdomains='';
						while(list($key,$val)=each($arrdomains))
						{
							$strdomains.=$val['domains']['domain_name'].",";
						}
						$strdomains=substr($strdomains,0,-1);
						$questions[$i]['questions']['domain_name']=$strdomains;
			
				}
				$this->set("questions",$questions);	
				$this->set("pageid",$pageid);	
		}
		
		public function editrecords($id='')
		{
				if($this->request->data)
				{
				
						 $id=$_POST['id'];
					
						 $grade=$_POST['grade'];
						 $topic=$_POST['topic'];
						 
						 $domain=$_POST['domain'];
						 
						 $Ques_img=$_FILES['Ques_img']['name'];
						 
						
						 if(empty($Ques_img))
						 {
							 $Ques_img=$_POST['imgvalue'];
						 }
						 else
						 {
								$filename="/questionimages/".$Ques_img;
								
								move_uploaded_file($_FILES['Ques_img']['tmp_name'],"/questionimages/".$Ques_img);
						  }
						  
						  
						$dataquestion=array();
						$dataquestion['file_name']=$Ques_img;
						$dataquestion['answer_key']=trim($_POST['answer_key']);
						$dataquestion['size']=trim($_POST['size']);
						$dataquestion['index_no']=trim($_POST['index_no']);
						$dataquestion['created_at']=date('Y-m-d H:i:s');
						
						if($id)
						{
							$dataquestion['id']=$id;
							$this->Question->Save($dataquestion,false);
							$qid=$id;
						}
						else
						{
							$dataquestion['id']="";
							$this->Question->Save($dataquestion,false);
							$qid=$this->Question->id;
						}
						  
						if(count($grade)>0)  
						{
						
						  $arrExistQuestionGrades = $this->QuestionGrade->find('all',array('conditions'=>array('question_id'=>$qid)));
						
							while(list($key,$val)=each($arrExistQuestionGrades))	
							{
								if(!in_array($val['QuestionGrade']['grade_id'],$grade))
								{
									$arrids[]=$val['QuestionGrade']['id'];
								}
							}


							$this->QuestionGrade->deleteAll(array('QuestionGrade.id' => $arrids), false);
						
							while(list($key,$val)=each($grade))
							{
								$tid=$val;
								if($tid)
								{
									$arrQuestionGrade = $this->QuestionGrade->find('first',array('conditions'=>array('grade_id'=>$tid,'question_id'=>$qid)));
					
									$dataQuestionGrade['id']='';
									$dataQuestionGrade['grade_id']=$tid;
									$dataQuestionGrade['question_id']=$qid;
									
									if(count($arrQuestionGrade)==0)
									{
										 $this->QuestionGrade->save($dataQuestionGrade,false);
									}
								}
							}
						}
						if(count($topic)>0)	
						{
						
							$arrExistQuestionTopic = $this->QuestionTopic->find('all',array('conditions'=>array('question_id'=>$qid)));
							
							
							$arrids=array();
							while(list($key,$val)=each($arrExistQuestionTopic))	
							{
							
								if(!in_array($val['QuestionTopic']['topic_id'],$topic))
								{
									 $arrids[]=$val['QuestionTopic']['id'];
								}
							}
							
							$this->QuestionTopic->deleteAll(array('QuestionTopic.id' => $arrids),false);
							
						  while(list($key,$val)=each($topic))
							{
								$tid=$val;
								if($tid)
								{
									$arrQuestionTopic = $this->QuestionTopic->find('first',array('conditions'=>array('topic_id'=>$tid,'question_id'=>$qid)));
					
									$dataQuestionTopic['id']='';
									$dataQuestionTopic['topic_id']=$tid;
									$dataQuestionTopic['question_id']=$qid;
									
									if(count($arrQuestionTopic)==0)
									{
										 $this->QuestionTopic->save($dataQuestionTopic,false);
									}
								}
							}
							
						 }
						if(count($domain)>0)	
						{	
							$arrExistQuestionDomain = $this->QuestionDomain->find('all',array('conditions'=>array('question_id'=>$qid)));
							
								$arrids=array();
								while(list($key,$val)=each($arrExistQuestionDomain))	
								{
									if(!in_array($val['QuestionDomain']['domain_id'],$domain))
									{
										$arrids[]=$val['QuestionDomain']['id'];
									}
								}
							$this->QuestionDomain->deleteAll(array('QuestionDomain.id' => $arrids),false);
								
							while(list($key,$val)=each($domain))
							{
							
								$tid=$val;
								if($tid)
								{
									$arrQuestionDomain = $this->QuestionDomain->find('first',array('conditions'=>array('domain_id'=>$tid,'question_id'=>$qid)));

									$dataQuestionDomain['id']='';
									$dataQuestionDomain['domain_id']=$tid;
									$dataQuestionDomain['question_id']=$qid;
									
									if(count($arrQuestionDomain)==0)
									{
										 $this->QuestionDomain->save($dataQuestionDomain,false);
									}
								}
							}
						}
						
						$this->set('message','Record updated successfully.');
						if(!$id)
							$this->redirect('/admins/records/1');
				}
				
				 $sql="select * from grade_levels";
				 $grade=$this->User->query($sql,false);
				 $this->set("gradeList",$grade);
				 $sql1="select * from topics";
				 $topics=$this->User->query($sql1,false);
				 $this->set("topicList",$topics);
				 
				 $sql2="select * from domains";
				 $domains=$this->User->query($sql2,false);
				 
				 $this->set("domainList",$domains);
				 
				
				 if(isset($id) && !empty($id))
				 {
						$sql3="select * from questions where id=".$id;
						$questions=$this->User->query($sql3,false);
						$this->set("questions",$questions);
						 
						 
						$qid=$id;
						$sql="select * from question_grades where question_id=$qid";
						$arrGrades=$this->User->query($sql,false);
						
						while(list($key,$val)=each($arrGrades))
						{
							$arrGradesIds[]=$val['question_grades']['grade_id'];
						}
						
						$sql="select * from question_topics where question_id=$qid";
						$arrTopics=$this->User->query($sql,false);
						
						while(list($key,$val)=each($arrTopics))
						{
							$arrTopicsIds[]=$val['question_topics']['topic_id'];
						}
						
						$sql="select * from question_domains where question_id=$qid";
						$arrdomains=$this->User->query($sql,false);
						
						while(list($key,$val)=each($arrdomains))
						{
							$arrdomainsIds[]=$val['question_domains']['domain_id'];
						}
						
						$this->set("arrGradesIds",$arrGradesIds);
						$this->set("arrTopicsIds",$arrTopicsIds);
						$this->set("arrdomainsIds",$arrdomainsIds);
						
						 $this->set("id",$questions[0]['questions']['id']);
						 $this->set("file_name",$questions[0]['questions']['file_name']);
						 $this->set("answer_key",$questions[0]['questions']['answer_key']);
						 $this->set("index_no",$questions[0]['questions']['index_no']);
						 $this->set("size",$questions[0]['questions']['size']);
					  }


		
		}


		public function adminLogin()
		{		
		
			$this->layout='admin_login';
			
			if($this->Session && $this->Session->read('useradmin'))
			   $this->redirect('/admins/index');	
			
			if($this->request->is('post'))	
			{

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
						$this->Session->write('useradmin',$user);
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

		
		public function importUsers()
		{

				$this->set('importuser','active');			
				$this->set('useractive','active');	
				
				if(!$this->Session->read('useradmin'))
				{
					$this->redirect('/admins/adminLogin');
				}
				if(isset($this->request->data))
				{
					
					$filename='';
					if (is_uploaded_file($_FILES['csvfile']['tmp_name'])) 
					{

						 $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
						 $i=0;
						 $new=0;
						 $updated=0;
						 while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
						 {
							if($i>0 && $data[0])
							{
								$userdata=array();
								$userdata['User']['email']=$data[0];
								$userdata['User']['user_password']=$data[1];
								$userdata['User']['user_role']=$data[2];
								$userdata['User']['first_name']=$data[3];
								$userdata['User']['last_name']=$data[4];
								$userdata['User']['activate']=$data[5];
							
								$existUser = $this->User->findByEmail($userdata['User']['email']);
								if(!$existUser)
								{
									$userdata['User']['created_at']=date('Y-m-d H:i:s');
								
									$this->User->save($userdata['User']);
									$Email = new CakeEmail();
									$Email->from(array('info@morgancreativegroup.com' => 'Student Booklet Builder'));
									$Email->to($userdata['User']['email']);
									$Email->subject('Account Activated');
									$Email->emailFormat('html');
								
									$message='Dear '.$userdata['User']['first_name']." ".$userdata['User']['last_name'].'<br/>'; 
									
									$message.="<p>Your account has been activated.</p><p>Login Details are as Follow:</p><p>Username: ".$userdata['User']['email']."<br/>Password: ".$userdata['User']['user_password']."</p><br/><br/>Thank you.<br/><br/><font color='#898989'>Rodel Student Booklet Builder Team</font><br/>";
							
									//$send=$Email->send($message);
									$new++;
									
								}
								else
								{
									$userdata['User']['id']=$existUser['User']['id'];
									$this->User->save($userdata['User']);
									$updated++;
								}
				

							}
							$i++;            
						}
					$this->set("importsuccess",1);
					$this->set("total",$i-1);
					$this->set("updated",$updated);
				    $this->set("new",$new);	
					
					fclose($handle);

					}
				}
				
		}
	}
?>