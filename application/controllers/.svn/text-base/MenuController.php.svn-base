<?php

class MenuController extends Zend_Controller_Action
{

    public function init() {

        
        if (! Bootstrap::isInGroup('administrator') && !Bootstrap::isInGroup('demo')) {
			$this->_redirect('/');
        }
        //*/
		$this->view->pageTitle = "Menu Management";
		$this->view->admin = true;
		$this->view->page = 'admin';

    }

    public function indexAction() {
		if(isset($_REQUEST['admin']))
			$this->view->menu = Bootstrap::getDataM('menu',' id > 0 AND type = "admin"','order ASC ');
		else
			$this->view->menu = Bootstrap::getDataM('menu',' id > 0 AND type = "front"','order ASC ');
    }
	public function addAction() {
		$this->_helper->layout()->disableLayout();
		$this->_redirect('/menu/edit');
	}
	public function editAction() {
		$form = new Default_Form_Menu();
		$form->setAction('/menu/edit/');
        if ($this->_request->isPost()) {
			
        		$data = array();
				$data = $this->_request->getPost();
				unset($data['submit']);
				if(empty($data['id'])) unset($data['id']);
				
				$menu = new Default_Model_Db('menu');
				$menu->save($data);
				$this->_redirect('/menu');
		}
		$id=$this->_request->getParam('id',null);

        if(!empty($id)) {
			$row=Bootstrap::getDataS('menu', "id = $id");

			// The form is populated from the DB           			
			$form->populate($row->toArray());
		}
		$this->view->form=$form;	
	}
}
