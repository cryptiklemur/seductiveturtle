<?php
class FaqController extends Zend_Controller_Action {
	
	public function init() {

		$this->view->pageTitle = "F.A.Q";
        
			$this->_redirect('/');
        /*if (! Bootstrap::isInGroup('administrator')) {
			$this->_redirect('/');
        }
        //*/

    }
	
	public function indexAction()	{
		$data = Bootstrap::getDataM('faq');
		$this->view->data = $data;
		
	}
	public function newAction() {
		$this->_helper->layout->setLayout("layout-cms");	
		if(!Bootstrap::isInGroup('administrator')) {
			$this->_redirect('/faq');
		}
		$form = new Default_Form_Faq();
		if($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
			$data = array();
			$data['faq_title'] = $this->_request->getPost('faq_title');
			$data['faq_content'] = $this->_request->getPost('faq_content');
			$faq = new Default_Model_Faq();
			$faq->save($data);
			$this->_redirect('/faq');
		}
		$this->view->form = $form;
	}
	public function editAction() {
		$this->_helper->layout->setLayout("layout-cms");	
		if(!Bootstrap::isInGroup('administrator')) {
			$this->_redirect('/faq');
		}
		$form = new Default_Form_Faq();
		if($this->_request->isGet()) {
			$data = Bootstrap::getDataS('faq','id='.$this->_request->getParam('id'));
				$form->getElement('id')->setValue($this->_request->getParam('id'));
				$form->getElement('faq_title')->setValue($data->faq_title);
				$form->getElement('faq_content')->setValue($data->faq_content);
		}
		if($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
			$data = array();
			$data['id'] = $this->_request->getPost('id');
			$data['faq_title'] = $this->_request->getPost('faq_title');
			$data['faq_content'] = stripslashes($this->_request->getPost('faq_content'));
			$faq = new Default_Model_Faq();
			$faq->save($data);
			$this->_redirect('/faq');
		}
		$this->view->form = $form;
	}
}
?>