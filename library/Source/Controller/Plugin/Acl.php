<?php
class Source_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

	public function preDispatch(Zend_Controller_Request_Abstract $request) {
	
		$request->setParam('test','ACL IS BEING LOADED');
		// Create the ACL
		$acl = new Zend_Acl();
		
		// Grab all the roles
		$roles = Bootstrap::getDataM('roles');
		
		// Grab the Base roles and add them to the ACL
		$base_roles = Bootstrap::getDataM('roles','parent_id IS NULL', 'parent_id ASC');
		foreach($base_roles as $role) {
			//echo "Guest added<br />";
			//echo "\$acl->addRole(new Zend_Acl_Role('".$role['role']."));<br />";
			$acl->addRole(new Zend_Acl_Role($role['role']));
		}

		// Grab the Advanced roles and add them to the ACL above their parent
		$advanced_roles = Bootstrap::getDataM('roles','parent_id IS NOT NULL', 'parent_id ASC');
		foreach($advanced_roles as $role) {
			
			$parent = Bootstrap::getDataS('roles','id = '.$role['parent_id']);
			//echo $role['role']." added under ".$parent['role'].'<br />';
			//echo "\$acl->addRole(new Zend_Acl_Role('".$role['role']."'), '".$parent['role']."');<br />";
			$acl->addRole(new Zend_Acl_Role($role['role']), $parent['role']);
		}
		// Grab resources, add them to an array, and then add them to the resources of the ACL
		$resources = Bootstrap::getDataM('permissions',null,null,null,'controller');
		foreach($resources as $resource) {
			//echo "\$acl->add(new Zend_Acl_Resource('".$resource['controller']."));<br />";
			$acl->add(new Zend_Acl_Resource($resource['controller']));
		}
		
		$resources = Bootstrap::getDataM('permissions');
		foreach($resources as $resource) {
			if($resource['role_id'] == 0){
				//echo "\$acl->allow(null, array('".$resource['controller']."'));<br />";
				$acl->allow(null, array($resource['controller']));
			}
			foreach($roles as $role) {
				if($resource['role_id'] == $role['id']) {
					// Grab all the actions for the current controller and role
					$actions = Bootstrap::getDataM('permissions','controller = "'.$resource['controller'].'" and role_id = "'.$resource['role_id'].'"');
					$array = array();
					foreach($actions as $action) { $array[] = $action['action']; }
					//echo "\$acl->allow('".$role['role']."', array('".$resource['controller']."',array(".implode(', ',$array)."'));<br />";
					$acl->allow($role['role'], $resource['controller'], $array);
				}
			}
		}

		// Special Permissions for Administrators
		$acl->allow('administrator', null);
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			if(!empty($identity->user_role)) {
				$role = strtolower($identity->user_role);
			} else {
				$role = 'guest';
			}
		} else {
			$role = 'guest';
		}
		$controller = $request->controller;
		$action = $request->action;
		if(!$acl->isAllowed($role, $controller, $action)) {
			if($role == 'guest') {
				$request->setControllerName('user');
				$request->setActionName('login');
			} else {
				$request->setControllerName('index');
				$request->setActionName('index');
			}
		}
		
	}
}
