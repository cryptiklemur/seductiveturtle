<?php

class WcsController extends Zend_Controller_Action
{

    public function init() {
		$this->view->pageTitle = "WCS Races";
		$this->view->admin = true;
		$this->view->page = 'admin';

    }

    public function indexAction() {
		$q = $this->_request->getParam('q',null);
		$races = empty($q) ? Bootstrap::getDataM('wcs','id > 0','req_level ASC') : Bootstrap::getDataM('wcs',"name LIKE '%$q%'");
		$paginator = Zend_Paginator::factory($races);
		$paginator->setItemCountPerPage(7)->setCurrentPageNumber($this->_request->getParam('page'));
		$this->view->races = $paginator;
    }
	public function viewAction() {
		$this->view->race = Bootstrap::getDataS('wcs','id = '.$this->_request->getParam('id'));
	}
	public function addAction() {
		$this->_helper->layout()->disableLayout();
		$this->_redirect('/wcs/edit');
	}
	public function editAction() {

        
        if (! Bootstrap::isInGroup('administrator') && !Bootstrap::isInGroup('demo')) {
			$this->_redirect('/');
        }
        //*/
		$this->view->pageTitle = "WCS Races";
		$this->view->admin = true;
		$this->view->page = 'admin';
		$form = new Default_Form_Wcs();
		$form->setAction('/wcs/edit/');
        if ($this->_request->isPost()) {
			
        		$data = array();
				$data = $this->_request->getPost();
				unset($data['submit']);
				if(empty($data['id'])) unset($data['id']);
				
				$menu = new Default_Model_Db('wcs');
				$menu->save($data);
				$this->_redirect('/wcs');
		}
		$id=$this->_request->getParam('id',null);

        if(!empty($id)) {
			$row=Bootstrap::getDataS('wcs', "id = $id");

			// The form is populated from the DB           			
			$form->populate($row->toArray());
		}
		$this->view->form=$form;	
	}
}
