<?php

class TemplateController extends Zend_Controller_Action {

	public function init() {

		// At this time ONLY users with admin permissions may use this file
		if (! Bootstrap::isInGroup('administrator') && !Bootstrap::isInGroup('demo')) {
			$this->_redirect('/user/login');
		}
		$this->view->pageTitle = "Admin Panel";
		$this->view->admin = true;
		$this->view->page = 'admin';
		//*/

	}

	public function indexAction() {
		$items = Bootstrap::getDataM('template');
		$this->view->items = $items;
		
	}
	public function editAction() {
		$this->_helper->layout->disableLayout();
		$id = $this->_request->getParam('id');
		$value = $this->_request->getParam('value');
		$data['id'] = $id;
		echo $id;
		$data['template_current_value'] = $value;
		echo $value;
		
		$color = new Default_Model_Db('template');
		$color->save($data);
	}
}

?>
