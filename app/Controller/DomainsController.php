<?php
Class DomainsController extends AppController 
{ 
	public $name = 'Domains';
	public $uses = array('User', 'Domain','Domain','DomainGrade','GradeLevel');

	 public function beforeFilter()
    {	
	
		$this->layout='admin';
		$action = $this->params->params['action'];
    }

	public function add($id='')
	{
	
		$this->set('listdomain','inactive');			
	    $this->set('adddomain','active');			
	    $this->set('domainactive','active');
	   
		//get user details everywhere like this.. 
		$userDetail = $this->Session->read('useradmin');
		$this->set('userDetail', $userDetail);
		
		$this->set('title_for_layout', 'Add Domain');
	
	
		if($this->request->is('post'))
		{
			$arrPostDomain=$this->request->data;
			$arrDomain = $this->Domain->find('first',array('conditions'=>array('Domain.domain_name'=>$this->request->data['Domain']['domain_name'])));
			
			if(count($arrDomain)==0)
			{
				$arrGrades=$this->request->data['Domain']['grade_id'];
				
				if(count($arrGrades)>0)
				{
					
					unset($this->request->data['Domain']['grade_id']);
				
					$this->Domain->save($this->request->data['Domain'],false);
					
					$domainid=$this->Domain->id;
					
					while(list($key,$val)=each($arrGrades))
					{
						
						$arrDomainGrade = $this->DomainGrade->find('first',array('conditions'=>array('domain_id'=>$domainid,'grade_id'=>$val)));
						
						$data['id']='';
						$data['domain_id']=$domainid;
						$data['grade_id']=$val;
						
						if(count($arrDomainGrade)==0)
						{
							 $this->DomainGrade->save($data,false);
						}
					 }
					 $this->set('message', 'Domain Added Succsesfuly!');
					 }
					 else
					{
					
						$this->set('message1', ' Please Select a grade!');
					}
			}
			else
			{
				if(!$id)
					$this->set('message1', 'Duplicate Domain! Try Diffrent Name');
			}
			$this->set('des', $arrPostDomain);
			
			if($id)
			{
				$domainid=$id;
				
				$arrGrades=$this->request->data['Domain']['grade_id'];
				
				if(count($arrGrades)>0)
				{
						$arrExistDomainGrade = $this->DomainGrade->find('all',array('conditions'=>array('domain_id'=>$domainid)));
						
						while(list($key,$val)=each($arrExistDomainGrade))	
						{
							if(!in_array($val['DomainGrade']['grade_id'],$arrGrades))
							{
								$arrids[]=$val['DomainGrade']['id'];
							}
						}

						$this->DomainGrade->deleteAll(array('DomainGrade.id' => $arrids), false);
						
						unset($this->request->data['Domain']['grade_id']);
						
						$this->Domain->save($this->request->data['Domain']);
					
						
						
						while(list($key,$val)=each($arrGrades))
						{
							
							$arrDomainGrade = $this->DomainGrade->find('first',array('conditions'=>array('domain_id'=>$domainid,'grade_id'=>$val)));
						
							$data['id']='';
							$data['domain_id']=$domainid;
							$data['grade_id']=$val;
							
							if(count($arrDomainGrade)==0)
							{
							
								 $this->DomainGrade->save($data,false);
							}
							
						 }
				 
						$this->set('message', 'Domain updated Succsesfuly!');
					}
					else
					{
						$this->set('message1', ' Please Select a grade!');
					}
			}
		}
		
		if($id)
		{
			  $arrDomain = $this->Domain->findById($id);
			  
			  $arrGrades=array(); 
			  while(list($key,$val)=each($arrDomain['DomainGrade']))
			  {
				$gradeData=$this->GradeLevel->findById($val['grade_id']);
				$strGrades.=$gradeData['GradeLevel']['level_name'].",";
				$gradeSelected[]=$val['grade_id'];
			  }
			  $strGrades=substr($strGrades,0,-1);
			  $arrDomain['Domain']['grades']=$strGrades;
			  $this->set('des', $arrDomain);
			  
			  $this->set('gradeSelected', $gradeSelected);
		}
		
		if($id)
		{
			   $desdata = $this->Domain->findById($id);
			   $this->set('des', $desdata);
		
				//$arrDomains = $this->Domain->find('all',array('conditions'=>array("grade_id"=>$desdata['Domain']['grade_id'])));
		}
		else
		{
			$arrDomains = $this->Domain->find('all');
		}
		
		$arrGrades = $this->GradeLevel->find('all');
		$this->set('arrGrades', $arrGrades);	
		
		
		$this->set('arrDomains', $arrDomains);	
		
	}
	
	public function index(){
	
	   $this->set('listdomain','active');			
	   $this->set('adddomain','inactive');			
	   $this->set('domainactive','active');
	   
	   $this->set('smallinfo', 'you can manage your all Domains here');
	   $this->set('title_for_layout', 'Domains');
	   $userDetail = $this->Session->read('useradmin');		
	   
	   $arrDomains = $this->Domain->find('all');

	  while(list($key1,$val1)=each($arrDomains))
	  {   
	    $strGrades='';
		while(list($key,$val)=each($val1['DomainGrade']))
		{
			$gradeData=$this->GradeLevel->findById($val['grade_id']);
			$strGrades.=$gradeData['GradeLevel']['level_name'].",";
		}
		  $strGrades=substr($strGrades,0,-1);
		  $arrDomains[$key1]['Domain']['grades']=$strGrades;
		}
	  
		
	  $this->set('designationResults', $arrDomains);
	
	}
	
	
	public function getDomainsDropDown($gradeid='',$topicid='',$selectedid=''){
		
		$arrConditions=array();
		
		if($gradeid)
		 $arrConditions['Domain.grade_id']=$gradeid;
	   
	   if($topicid)
		 $arrConditions['Domain.topic_id']=$topicid;
	   
	   
	   $arrDomains = $this->Domain->find('all',array('conditions'=>$arrConditions));
	   $selecthtml='<option>----Select Domain----</option>';
	   while(list($key,$val)=each($arrDomains))
	   {
			if($selectedid==$val['Domain']['id'])
				$selecthtml.='<option selected value="'.$val['Domain']['id'].'">'.$val['Domain']['domain_name'].'</option>';
			else
				$selecthtml.='<option  value="'.$val['Domain']['id'].'">'.$val['Domain']['domain_name'].'</option>';
		
	   }
	   //$selecthtml.="</select>";
	   echo $selecthtml;exit;
	}
	
	
	public function delete($id = NULL) 
	{
		 if($this->Domain->delete($id))
		 {
			$this->Session->setFlash('The Domain has been deleted', 'default', array(), 'delete');		   
			$this->redirect(array('action'=>'index'));
		 }
	} 
}
?>