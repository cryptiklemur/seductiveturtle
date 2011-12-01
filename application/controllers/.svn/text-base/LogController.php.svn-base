<?php

class LogController extends Zend_Controller_Action
{

    public function init() {
        $this->view->pageTitle = "The Holy Grail (aka LOG)";
        if (! Bootstrap::isInGroup('administrator') && !Bootstrap::isInGroup('demo')) {
			$this->_redirect('/');
        }
        //*/
		$this->view->admin = true;
		$this->view->page = 'admin';

    }

    public function indexAction() {
		$this->view->logs = Bootstrap::getDataM('log','visible = "true"','log_time DESC');
    }
	public function cleanAction() {
		Default_Model_Logger::clean();
		$this->_redirect('/log/index/');
	}
}