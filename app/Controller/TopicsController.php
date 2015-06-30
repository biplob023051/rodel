<?php
Class TopicsController extends AppController 
{ 
	public $name = 'Topics';
	public $uses = array('User', 'Topic','TopicGrade','GradeLevel');

	 public function beforeFilter()
    {	
	
		$this->layout='admin';
		$action = $this->params->params['action'];
    }

	public function add($id='')
	{
	
	    $this->set('listtopic','inactive');			
		$this->set('addtopic','active');			
		$this->set('topicactive','active');
			
		//get user details everywhere like this.. 
		$userDetail = $this->Session->read('useradmin');
		$this->set('userDetail', $userDetail);
		
		$this->set('title_for_layout', 'Add Topic');
	
	
		if($this->request->is('post'))
		{
			$arrPostTopic=$this->request->data;
			$arrTopic = $this->Topic->find('first',array('conditions'=>array('Topic.topic_name'=>$this->request->data['Topic']['topic_name'])));
			
			if(count($arrTopic)==0)
			{
				$arrGrades=$this->request->data['Topic']['grade_id'];
				
				if(count($arrGrades)>0)
				{
					
					unset($this->request->data['Topic']['grade_id']);
				
					$this->Topic->save($this->request->data['Topic'],false);
					
					$topicid=$this->Topic->id;
					
					while(list($key,$val)=each($arrGrades))
					{
						
						$arrTopicGrade = $this->TopicGrade->find('first',array('conditions'=>array('topic_id'=>$topicid,'grade_id'=>$val)));
						
						$data['id']='';
						$data['topic_id']=$topicid;
						$data['grade_id']=$val;
						
						if(count($arrTopicGrade)==0)
						{
							 $this->TopicGrade->save($data,false);
						}
					 }
					 $this->set('message', 'Topic Added Succsesfuly!');
					 }
					 else
					{
					
						$this->set('message1', ' Please Select a grade!');
					}
			}
			else
			{
				if(!$id)
					$this->set('message1', 'Duplicate Topic! Try Diffrent Name');
			}
			$this->set('des', $arrPostTopic);
			if($id)
			{
				$topicid=$id;
				
				$arrGrades=$this->request->data['Topic']['grade_id'];

				if(count($arrGrades)>0)
				{
						$arrExistTopicGrade = $this->TopicGrade->find('all',array('conditions'=>array('topic_id'=>$topicid)));
						while(list($key,$val)=each($arrExistTopicGrade))	
						{
							if(!in_array($val['TopicGrade']['grade_id'],$arrGrades))
							{
								$arrids[]=$val['TopicGrade']['id'];
							}
						}

						$this->TopicGrade->deleteAll(array('TopicGrade.id' => $arrids), false);
						
						unset($this->request->data['Topic']['grade_id']);
						
						$this->Topic->save($this->request->data['Topic']);
						
						//$this->TopicGrade->deleteAll(array('topic_id'=>$topicid,'grade_id'=>$val), false);
						
						while(list($key,$val)=each($arrGrades))
						{
							
							$arrTopicGrade = $this->TopicGrade->find('first',array('conditions'=>array('topic_id'=>$topicid,'grade_id'=>$val)));
							
							$data['id']='';
							$data['topic_id']=$topicid;
							$data['grade_id']=$val;
							
							if(count($arrTopicGrade)==0)
							{
								 $this->TopicGrade->save($data,false);
							}
						 }
				 
						$this->set('message', 'Topic updated Succsesfuly!');
					}
					else
					{
						$this->set('message1', ' Please Select a grade!');
					}
			}
		}
		
		if($id)
		{
			  $arrTopic = $this->Topic->findById($id);
			  $arrGrades=array(); 
			  while(list($key,$val)=each($arrTopic['TopicGrade']))
			  {
				$gradeData=$this->GradeLevel->findById($val['grade_id']);
				$strGrades.=$gradeData['GradeLevel']['level_name'].",";
				$gradeSelected[]=$val['grade_id'];
			  }
			  $strGrades=substr($strGrades,0,-1);
			  $arrTopic['Topic']['grades']=$strGrades;
			  $this->set('des', $arrTopic);
			  $this->set('gradeSelected', $gradeSelected);
		}
		
		$arrGrades = $this->GradeLevel->find('all');
		$this->set('arrGrades', $arrGrades);		
	}
	
	public function index(){
		
	   $this->set('listtopic','active');			
	   $this->set('addtopic','inactive');			
	   $this->set('topicactive','active');
	   
	   $this->set('smallinfo', 'you can manage your all Topics here');
	   $this->set('title_for_layout', 'Topics');
	   
	   $userDetail = $this->Session->read('useradmin');		
	   
	   $arrTopics = $this->Topic->find('all');
	  	   
	  while(list($key1,$val1)=each($arrTopics))
	  {   
	    $strGrades='';
		while(list($key,$val)=each($val1['TopicGrade']))
		{
			$gradeData=$this->GradeLevel->findById($val['grade_id']);
			$strGrades.=$gradeData['GradeLevel']['level_name'].",";
		}
		  $strGrades=substr($strGrades,0,-1);
		  $arrTopics[$key1]['Topic']['grades']=$strGrades;
		}
	  
		$this->set('designationResults', $arrTopics);
	  
	}
	
	public function getTopicsDropDown($gradeid='',$selectedid=''){
		
		$arrConditions=array();
		
		if($gradeid)
		 $arrConditions=array('grade_id'=>$gradeid);
	   
	   $arrTopics = $this->Topic->find('all',array('conditions'=>$arrConditions));
	   $selecthtml='<option>----Select Topic----</option>';
	   while(list($key,$val)=each($arrTopics))
	   {
			if($selectedid==$val['Topic']['id'])
				$selecthtml.='<option selected value="'.$val['Topic']['id'].'">'.$val['Topic']['topic_name'].'</option>';
			else
				$selecthtml.='<option  value="'.$val['Topic']['id'].'">'.$val['Topic']['topic_name'].'</option>';
		
	   }
	   //$selecthtml.="</select>";
	   echo $selecthtml;exit;
	}
	
	public function delete($id = NULL) 
	{
		 if($this->Topic->delete($id)){
			$this->Session->setFlash('The Topic has been deleted', 'default', array(), 'delete');		   
			$this->redirect(array('action'=>'index'));
		 }
	} 
	
	
}
?>