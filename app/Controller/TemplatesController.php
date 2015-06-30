<?php
/*
* Template management controller
*/
Class TemplatesController extends AppController {

	public function beforeFilter() {	
		$this->layout='admin';
		if ($this->Session->check('Sheet.template')) {
			$template = $this->Session->read('Sheet.template');
			$this->set(compact('template'));
		}
    }
	
	/*
	* List of all template
	*/
	public function index() {
		$this->set('title_for_layout', __('List of Templates'));
		$this->loadModel('Sheet');
		$this->Sheet->unbindModel(array('hasMany' => array('SheetPage'), 'hasOne' => array('TeacherPage')));
		$this->Sheet->bindModel(
	        array(
	           'belongsTo'=>array(
	                'User'=>array(
	                    'className'=>'User',
	                    'foreignKey'=>'user_id'
	                 )
	            )
	        )
	    );
		$sheets = $this->Sheet->find('all', array(
			'conditions' => array('Sheet.type' => 'admin'),
			'fields' => array('Sheet.*', 'User.first_name', 'User.last_name')
		));
		$this->set(compact('sheets'));
	}

	/*
	* Add template
	*/
	public function add($editWorkSheet = null) {
		$this->set('title_for_layout', __('Templates Management'));
		$templateOptions = array('teacher' => __('Teacher'), 'math specialist' => __('Math Specialist'));
		$this->set(compact('templateOptions'));
		$userData = $this->Session->read('useradmin');
		if(sizeof($userData)>0){
			// biplob start
			if ($editWorkSheet) {
				$review_data = $this->Session->read('SheetPage');
				// if session expired
				if (empty($review_data)) {
				$this->Session->delete('Sheet');
				$this->Session->delete('SheetPage');
				return $this->redirect(array('controller' => 'templates', 'action' => 'index'));
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
				if (!empty($this->request->data['Sheet']['name']) && !empty($this->request->data['Sheet']['template'])) {
					$sheetNameExist = $this->Sheet->find('first', array(
						'conditions' => array(
							'Sheet.name' => $this->request->data['Sheet']['name'],
							'Sheet.type' => 'admin',
						)
					));
					if (!empty($sheetNameExist)) {
						$this->Session->setFlash(__('You have created a worksheet using the same name, please choose a unique name.'), 'error_form', array(), 'error');
					} else {
						$this->Session->write('Sheet.name', $this->request->data['Sheet']['name']);
						$this->Session->write('Sheet.template', $this->request->data['Sheet']['template']);
						$this->set('template', $this->request->data['Sheet']['template']);
					}
				} else {
					$this->Session->setFlash(__('Please choose template name and template type'), 'error_form', array(), 'error');
				}
			}	       			
			$sheets = $this->Sheet->find('all', array(
				'conditions' => array('Sheet.user_id' => $userData['User']['id']),
				'fields' => array('Sheet.id', 'Sheet.name')
			));
			$this->set(compact('sheets'));
			// biplob end
			$this->loadModel('User');
			$userDetail = $this->User->find('first',array('conditions'=>array('User.id'=>$userData['User']['id'])));        
			$this->set('userDetail',$userDetail);
			$this->loadModel('GradeLevel');
			$gradeLevel = $this->GradeLevel->find('all');
			$this->set('listGrade',$gradeLevel);
			$this->set('selectGrade',"Grade Level");
			$this->set('selectTopics',"Math topics &amp; tips");
			$this->set('selectDomains',"Domains");
		}
		else{
			$this->redirect('/');
		}
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
		$template = $this->Session->read('Sheet.template');
		if ($template == 'teacher') {
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
		
		$this->render('/Elements/templates/edit_sheet');
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
		$this->render('/Elements/templates/edit_sheet');
	}

	/*
	* Worksheet review
	*/
	public function review($template_id = null) {
		$this->set('title_for_layout', __('Templates Review'));
		$templateOptions = array('teacher' => __('Teacher'), 'math specialist' => __('Math Specialist'));
		$this->set(compact('templateOptions'));
		$userData = $this->Session->read('useradmin');
		if (empty($template_id)) {
			$review_data = $this->Session->read('SheetPage');
			if (empty($review_data)) {
				return $this->redirect(array('controller' => 'templates', 'action' => 'index'));
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
			$this->loadModel('User');
			$userDetail = $this->User->find('first',array('conditions'=>array('User.id'=>$userData['User']['id'])));        
			$this->set('userDetail',$userDetail);
			$this->set('selectGrade',"Grade Level");
			$this->set('selectTopics',"Math topics &amp; tips");
			$this->set('selectDomains',"Domains");
		}
		$sheets = $this->Sheet->find('all', array(
						'conditions' => array('Sheet.user_id' => $userData['User']['id']),
						'fields' => array('Sheet.id', 'Sheet.name')
					));
		$this->set(compact('sheets'));
	}

	/*
	* Teacher page save
	*/
	public function ajax_savepage(){
		$this->autoRender = false;
		$this->loadModel('Sheet');
		$c_user = $this->Session->read('useradmin');
		$sheetPageData = $this->Session->read('SheetPage');
		$template = $this->Session->read('Sheet.template');
		if ($this->Session->check('Sheet.id')){
			$sheetData['Sheet']['id'] = $this->Session->read('Sheet.id');
			$this->Sheet->SheetPage->deleteAll(array('SheetPage.sheet_id' => $sheetData['Sheet']['id']));
		}
		foreach ($sheetPageData as $key => $value) {
			$sheetData['SheetPage'][$key]['params'] = $value;
		}
		$sheetData['Sheet']['name'] = $this->Session->read('Sheet.name');
		$sheetData['Sheet']['user_id'] = $c_user['User']['id'];
		$sheetData['Sheet']['type'] = 'admin';
		$sheetData['Sheet']['template'] = $template;
		$this->Sheet->saveAll($sheetData);
		$this->Session->write('Sheet.id', $this->Sheet->id);
		$this->Session->write('Sheet.template', $template);
	}

	/*
	* Teacher print page
	*/
	public function ajax_printpage() {
		$this->layout = 'ajax';
		$review_data = $this->Session->read('SheetPage');
		if (empty($review_data)) {
			return $this->redirect(array('controller' => 'templates', 'action' => 'index'));
		}
		$c_user = $this->Session->read('useradmin');
		$template = $this->Session->read('Sheet.template');

		if (!empty($this->request->data['spanish']) && empty($this->request->data['answerkey'])) {
			if ($template == 'teacher') {
				$this->set('questions', json_decode($review_data[$this->request->data['save_index']], true));
			} else {
				foreach ($review_data as $key => $value) {
					$all_pages[$key] = json_decode($value, true);
				}
				$this->set(compact('all_pages'));
			}

		} elseif (empty($this->request->data['spanish']) && empty($this->request->data['answerkey'])) {
			if ($template == 'teacher') {
				$this->set('questions', json_decode($review_data[$this->request->data['save_index']], true));
			} else {
				foreach ($review_data as $key => $value) {
					$all_pages[$key] = json_decode($value, true);
				}
				$this->set(compact('all_pages'));
			}

		} elseif (!empty($this->request->data['spanish']) && !empty($this->request->data['answerkey'])) {
			if ($template == 'teacher') {
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
			if ($template == 'teacher') {
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
		$c_user = $this->Session->read('useradmin');
		$this->Sheet->unbindModel(array('hasOne' => array('TeacherPage')));
		$sheet = $this->Sheet->findById($this->request->data['id']);
		$this->Session->delete('Sheet');
		$this->Session->delete('SheetPage');
		$this->Session->write('Sheet.id', $sheet['Sheet']['id']);
		$this->Session->write('Sheet.name', $sheet['Sheet']['name']);
		$this->Session->write('Sheet.template', $sheet['Sheet']['template']);
		// for teacher
	
		$questions = json_decode($sheet['SheetPage'][0]['params'], true);
		if ($sheet['Sheet']['template'] == 'teacher') {
			$this->Session->write('SheetPage.0', $sheet['SheetPage'][0]['params']);
		} else {
			$this->set('page_count', count($sheet['SheetPage']));
			foreach ($sheet['SheetPage'] as $key => $value) {
				$this->Session->write('SheetPage.' . $key, $value['params']);
			}
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

	/*
	* Find all Problems or Questions
	*/
	public function ajax_problems() {
		$this->layout = 'ajax';
		if (!empty($this->request->data['grade_id'])) { // if problems searching by grade level
			$this->loadModel('QuestionGrade');
			$this->QuestionGrade->unbindModel(array('hasMany' => array('GradeLevel')));
			$questions = $this->QuestionGrade->find('all', array(
				'conditions' => array('QuestionGrade.grade_id' => $this->request->data['grade_id']),
				'fields' => array('Question.*')
			));
		} elseif (!empty($this->request->data['topic_id'])) { // if problem searching by topic
			$this->loadModel('QuestionTopic');
			$this->QuestionTopic->unbindModel(array('hasMany' => array('Topic')));
			$questions = $this->QuestionTopic->find('all', array(
				'conditions' => array('QuestionTopic.topic_id' => $this->request->data['topic_id']),
				'fields' => array('Question.*')
			));
		} elseif (!empty($this->request->data['domain_id'])) { // if problem searching by domain
			$this->loadModel('QuestionDomain');
			$this->QuestionDomain->unbindModel(array('hasMany' => array('Domain')));
			$questions = $this->QuestionDomain->find('all', array(
				'conditions' => array('QuestionDomain.domain_id' => $this->request->data['domain_id']),
				'fields' => array('Question.*')
			));
		}
		$this->set(compact('questions'));
	}

	/*
	* Find all Topics by grade level
	*/
	public function ajax_topics() {
		$this->layout = 'ajax';
		$this->loadModel('TopicGrade');
		$this->TopicGrade->unbindModel(array('hasMany' => array('GradeLevel')));
		$topics = $this->TopicGrade->find('all', array(
			'conditions' => array('TopicGrade.grade_id' => $this->request->data['grade_id']),
			'fields' => array('Topic.id', 'Topic.topic_name')
		));
		$this->set(compact('topics'));
	}

	/*
	* Find all Domains by grade level
	*/
	public function ajax_domains() {
		$this->layout = 'ajax';
		$this->loadModel('DomainGrade');
		$this->DomainGrade->unbindModel(array('hasMany' => array('GradeLevel')));
		$domains = $this->DomainGrade->find('all', array(
			'conditions' => array('DomainGrade.grade_id' => $this->request->data['grade_id']),
			'fields' => array('Domain.id', 'Domain.domain_name')
		));
		$this->set(compact('domains'));
	}

	/*
	* Delete admin template
	*/
	public function delete($id = NULL) {
		$this->loadModel('Sheet');
		 $this->Sheet->SheetPage->deleteAll(array('SheetPage.sheet_id' => $id));
		 if($this->Sheet->delete($id)){
			$this->Session->setFlash('The Template has been deleted', 'default', array(), 'delete');		   
			$this->redirect(array('action'=>'index'));
		 }
	} 
}
?>