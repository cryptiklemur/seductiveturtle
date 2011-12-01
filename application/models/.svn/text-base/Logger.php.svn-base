<?php

/**
 * Description of Resource
 *
 * @author
 */
class Default_Model_Logger extends Zend_Db_Table_Abstract {

    protected $_name="log";
    protected $_primary="id";
	
	public function __construct() { parent::__construct(); }
	public function save($data) {
		if(isset($data['id'])) {
			$id = $data['id'];
			parent::update($data,array('id =?'=>$id));
		}
		else {
			parent::insert($data);
		}
	}
	public function remove($id) { parent::delete(array('id = ?' => $id)); }
	public static function log($content) {
		$referer = $_SERVER['REQUEST_URI'];
		$referer = strlen($referer) < 1 ? 'Index' : $referer;
		$data['log_content'] = $content;
		$data['log_time'] = time();
		$data['log_referer'] = $referer;
		$log = new Default_Model_Logger();
		$log->save($data);
	}
	public function hideLogs() {
		$data = array('visible' => 'false');		
		parent::update($data,array('visible = ?' =>'true'));
	}
	public static function clean() {
			$log = new Default_Model_Logger();
			$log->hideLogs();
	}
		
}
?>
