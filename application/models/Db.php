<?php

class Default_Model_Db extends Zend_Db_Table_Abstract {
	
	protected $_name 	= null;
	protected $_primary = null;
	protected $_data	= null;
	
	public function __construct($tbl, $key='id', $data=null) {
		$this->_name = $tbl;
		if(!empty($key))  $this->_primary = $key;
		parent::__construct();
		if(!empty($data)) $this->_data	  = $data;
	}
	public function save($data = null, $tracker = false) {
		if(Bootstrap::isInGroup('administrator') || $tracker) {
			if(!empty($data)) $this->_data = $data;
			if (isset($this->_primary) && isset($this->_data[$this->_primary])) {
				if(isset($this->_data['_origData'])) {
					$this->_data['_origData']['class'] = $this->_name;
					unset($this->_data['_origData']);
				}
				return parent::update( $this->_data, array( $this->_primary . " = ?" => $this->_data[$this->_primary] ) );
			} else {
					return parent::insert( $this->_data );
			}
		} else {
			die("Must Log in");
		}
	}
	public function remove() {
		if(Bootstrap::isInGroup('administrator')) {
			if (isset($this->_primary) && isset($this->_data[$this->_primary])) {
				if(isset($this->_data['_origData'])) {
					$this->_data['_origData']['class'] = $this->_name;
					Bootstrap::backup($this->_data['_origData']);
					unset($this->_data['_origData']);
				}
				return parent::delete( array( $this->_primary . " = ?" => $this->_data[$this->_primary] ) );
			}
		}
	}
}
