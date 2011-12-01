<?php

/**
 * Description of Resource
 *
 * @author
 */
class Default_Model_Config extends Zend_Db_Table_Abstract {

    protected $_name="config";
    protected $_primary="id";
	
	public function __construct() { parent::__construct(); }
	public function save($data) {
		foreach($data as $section=>$name) {
			foreach($name as $key=>$value) {
				$save['config_current_value'] = $value;
				parent::update($save,array('config_section = "'.$section.'" AND config_name = "'.$key.'"'));
			}
		}
	}
	public function remove($id) { parent::delete(array('id = ?' => $id)); }
}
?>