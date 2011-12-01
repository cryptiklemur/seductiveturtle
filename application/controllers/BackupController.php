<?php

class BackupController extends Zend_Controller_Action {
	
	public function init() {

        // At this time ONLY users with admin permissions may use this file
        if (! Bootstrap::isInGroup('administrator')) {
			$this->_redirect('/user/login');
        }
        //*/

    }
	
	public function indexAction() {
		$this->_helper->layout->setLayout("layout-admin");
	}
	public function restoreAction() {
		if($this->_request->isGet()) {
			$id = $this->_request->getParam('id');
			$backup = Bootstrap::getDataS('backup','id = '.$id);
			$config = new Zend_Config_Ini(Bootstrap::getConfig('site','base_dir').'/application/configs/application.ini',APPLICATION_ENV);
			$config = $config->resources->db->params;
			$db = Zend_Db::factory('Pdo_Mysql',$config);
			$db->query($backup->backup_sql);
			$this->_redirect($this->_request->getParam('referer'));
		}
		else {
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function previewAction() {
		if($this->_request->isGet()) {
			$id = $this->_request->getParam('id');
			$backup = Bootstrap::getDataS('backup','id = '.$id);
			$this->view->preview = stripslashes($backup->backup_preview);
			$this->view->id = $id;
			$this->view->referer = $_SERVER['HTTP_REFERER'];
		}
	}
}
?>