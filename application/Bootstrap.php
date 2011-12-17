<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{

		define('ROOT_DIR', dirname(dirname(__FILE__)));

		$autoloader = new Zend_Application_Module_Autoloader(array(
					'namespace' => 'Default',
					'basePath'  => dirname(__FILE__),
					));

		function __($string) { return $string; } //may want spanish translation


		Zend_Layout::startMvc(array('layoutPath' => ROOT_DIR.'/application/views/layouts'));
		$config['strict'] = 'true';
		Zend_Session::start();
		Zend_Session::setOptions($config);

	}
	
	public static function loadConfig() {
		$configData = Bootstrap::getDataM('config');
		foreach($configData as $value) {
			$_SESSION['config'][$value->config_section."_".$value->config_name]['value'] = isset($value->config_current_value) ? $value->config_current_value : $value->config_default_value;
			$_SESSION['config'][$value->config_section."_".$value->config_name]['type'] = $value->config_element_type;
		}
	}
	public static function getConfig($section, $value) {
		$return = "No config for ".$section."_".$value;
		if(isset($_SESSION['config'][$section."_".$value])) {
			$return = $_SESSION['config'][$section."_".$value];
			if($return['type'] == 'time') {
				$value = explode('*',$return['value']);
				$new_value = (int) $value[0];
				for($i = 1; $i < sizeof($value); $i++) {
					$new_value *= $value[$i];
				}
				$return['value'] = $new_value;
			}
		}
		else {
			Bootstrap::log("No config for ".$section."_".$value);
		}
		return $return['value'];
	}
	public static function setConfig($section,$name,$value) {
		$config = new Default_Model_Config();
		$select = new Zend_Db_Table_Select($config);
		$select->where('config_section = ?', $section)
			->where('config_name = ?', $name);
		$id = $config->fetchRow($select)->id;
		$config = new Default_Model_Db('config');
		$data['id'] = $id;
		$data['config_current_value'] = $value;
		$config->save($data);
	}
	
	public static function getDataS($var, $where = null, $key = 'id', $log=false) {
		$model = new Default_Model_Db($var,$key);
		$select = new Zend_Db_Table_Select($model);
		if(isset($where))$select->where($where);
		if($log) Bootstrap::log($select->__ToString());
		return $model->fetchRow($select);
	}
	
	public static function getDataM($var, $where = null, $order = null, $key = 'id', $log=false) {
		$model = new Default_Model_Db($var,$key);
		$select = new Zend_Db_Table_Select($model);
		if(isset($where))$select->where($where);
		if(isset($order))$select->order($order);
		if($log) Bootstrap::log($select->__ToString());
		return $model->fetchAll($select);
	}
	public function loadSession() {

		//load all REQUIRED session variables

		if (! isset($_SESSION['usertype'])) {
			$_SESSION['usertype']= array('0' => 'guest');
		}

		if (! isset($_SESSION['user_id'])) {
			$_SESSION['user_id']=null;
		}

	}
	public function isInGroup($group) {
		if (! isset($_SESSION['usertype'])) {
			//$this->loadSession();
			Bootstrap::loadSession();
		}
		foreach($_SESSION['usertype'] as $usertype) {
			if($usertype == $group) return true;
		}
	}
	public function isLogged() {
		if(isset($_SESSION['user_id'])) return true;
		return false;
	}
	public function assertSession($key,$value) {
		//this function can and should be called by itself
		if (! isset($_SESSION['usertype'])) {
			//$this->loadSession();
			Bootstrap::loadSession();
		}
		$flag=false;
		if ($_SESSION[$key]==$value) {
			$flag=true;
		}
		return $flag;
	}

	//public function assertAcl() ?? not sure yet
	public static function getUser() {
		if (! isset($_SESSION['user_id'])) {
			//$this->loadSession();
			Bootstrap::loadSession();
		}
		return $_SESSION['user_id'];
	}

	public static function parseHost($serverName) {

		$return_data=array("a"=>null,"b"=>null,"c"=>null);
		$lastDot=strrpos($serverName,".");
		$fullLen=strlen($serverName);
		$return_data['c']=substr($serverName,$lastDot+1,$fullLen);
		$firstDot=strpos($serverName,".");

		if ($lastDot==$firstDot) {
			//leaving ['a'] null
			$return_data['b']=substr($serverName,0,$fullLen);
			return $return_data;
		} //else (not necessary)

		$middleLen=$lastDot-$firstDot-1;
		$return_data['b']=substr($serverName,$firstDot+1,$middleLen);
		$return_data['a']=substr($serverName,0,$firstDot);
		return $return_data;
	}

	public static function log($content) {
		if(!is_string($content)) return Default_Model_Logger::log(print_r($content,true));
		return Default_Model_Logger::log($content);
	}

	public static function smart_trim($text, $max_len, $trim_middle = false, $trim_chars = '...')
	{
		$text = trim($text);

		if (strlen($text) < $max_len) {

			return $text;

		} elseif ($trim_middle) {

			$hasSpace = strpos($text, ' ');
			if (!$hasSpace) {
				/**
				 * The entire string is one word. Just take a piece of the
				 * beginning and a piece of the end.
				 */
				$first_half = substr($text, 0, $max_len / 2);
				$last_half = substr($text, -($max_len - strlen($first_half)));
			} else {
				/**
				 * Get last half first as it makes it more likely for the first
				 * half to be of greater length. This is done because usually the
				 * first half of a string is more recognizable. The last half can
				 * be at most half of the maximum length and is potentially
				 * shorter (only the last word).
				 */
				$last_half = substr($text, -($max_len / 2));
				$last_half = trim($last_half);
				$last_space = strrpos($last_half, ' ');
				if (!($last_space === false)) {
					$last_half = substr($last_half, $last_space + 1);
				}
				$first_half = substr($text, 0, $max_len - strlen($last_half));
				$first_half = trim($first_half);
				if (substr($text, $max_len - strlen($last_half), 1) == ' ') {
					/**
					 * The first half of the string was chopped at a space.
					 */
					$first_space = $max_len - strlen($last_half);
				} else {
					$first_space = strrpos($first_half, ' ');
				}
				if (!($first_space === false)) {
					$first_half = substr($text, 0, $first_space);
				}
			}

			return $first_half.$trim_chars.$last_half;

		} else {


			$trimmed_text = substr($text, 0, $max_len);
			$trimmed_text = trim($trimmed_text);
			if (substr($text, $max_len, 1) == ' ') {
				/**
				 * The string was chopped at a space.
				 */
				$last_space = $max_len;
			} else {
				/**
				 * In PHP5, we can use 'offset' here -Mike
				 */
				$last_space = strrpos($trimmed_text, ' ');
			}
			if (!($last_space === false)) {
				$trimmed_text = substr($trimmed_text, 0, $last_space);
			}
			return Bootstrap::remove_trailing_punctuation($trimmed_text).$trim_chars;

		}

	}

	/**
	 * Strip trailing punctuation from a line of text.
	 *
	 * @param  string $text The text to have trailing punctuation removed from.
	 *
	 * @return string       The line of text with trailing punctuation removed.
	 */
	public static function remove_trailing_punctuation($text)
	{
		return preg_replace("'[^a-zA-Z_0-9]+$'s", '', $text);
	}
	public static function pr($array) {
		echo "<pre>".print_r($array,true)."</pre>";
	}
	//gets the data from a URL
	public static function tinyUrl($url)
	{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}

