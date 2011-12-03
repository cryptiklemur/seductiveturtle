<?php

class UserController extends Zend_Controller_Action
{
	public function init() {

		$config['cookie_lifetime'] = Bootstrap::getConfig('session','length');
		$config['gc_maxlifetime'] = Bootstrap::getConfig('session','length');
		$config['remember_me_seconds'] = Bootstrap::getConfig('session','length');
		$config['cookie_path'] = '/';
		$config['cookie_domain'] = Bootstrap::getConfig('site','url');
		Zend_Session::setOptions($config);
		$this->view->admin = true;
		$this->view->page = 'admin';
	}

	public function loginAction() {
	  	$this->view->pageTitle = "Login";
		$auth = Zend_Auth::getInstance();
		if ($this->_request->isPost()) {


			$username=$this->_request->getParam('username');
			$password=$this->_request->getParam('password');
			$user_table=new Default_Model_Db('user');
			$db=$user_table->getAdapter();
			$adapter = new Zend_Auth_Adapter_DbTable($db);
			$adapter->setTableName('user')
			->setIdentityColumn('user_screen_name')
			->setCredentialColumn('user_password');

			$adapter->setIdentity($username)
			->setCredential(md5($password));
			$result = $auth->authenticate($adapter);
			/*For Email Validation*/
			$row=$adapter->getResultRowObject();
			$userRow = Bootstrap::getDataS('user',"user_screen_name = '$username'");
			if (!empty($userRow)) {
				$confirmKey=$userRow->user_register;
				if ($confirmKey == '1') {
					if ($userRow['user_password'] == md5($password)) { //$result->isValid()) {
						$row=$adapter->getResultRowObject();
						$groupIds=explode(',',$row->user_group_id);
						$groups = array();
						foreach($groupIds as $groupId) {
							$groupRow = Bootstrap::getDataS('group',"id = '$groupId'");
							$groups[] = $groupRow->group_name;
						}
						$_SESSION['usertype'] = $groups;
							
						$_SESSION['username']=$row->user_screen_name;
						$_SESSION['user_id']=$row->id;
						if(isset($row->user_firstname)) $_SESSION['firstname'] = $row->user_firstname;
							
						$auth->clearIdentity();
						$auth->getStorage()->write($row->id);

						$storage = new Zend_Auth_Storage_Session();
						$storage->write($adapter->getResultRowObject());

						$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
						//$this->_redirect("/admin");
						
					}//*/
				} else {
					//can have another if here for
					//$this->view->errorMessage = "Either you need to confirm your registration or your account has been disabled.";
					$_SESSION['msg']['login-err'] = "Either you need to confirm your registration or your account has been disabled.";
				}
			} else {
				//$this->view->errorMessage = "Invalid username or password. Please try again.";
				$_SESSION['msg']['login-err'] = "Invalid username or password. Please try again.";
			}

		}
		else
			unset($_SESSION);
	}

	public function indexAction() {
		$this->_redirect('/user/register/');
	}

	public function logoutAction() {
		$_SESSION=array();
		session_destroy();
		$_SESSION=null;
		if ($this->_request->getParam('home')) {
			$this->_redirect("/");
		}
		$this->_redirect("/user/login");
	}
	public function addAction() {
		if(!Bootstrap::isInGroup('administrator') && !Bootstrap::isInGroup('demo')) {
			$this->_redirect('/user/login/');
		}
		$this->view->ck = true;
		$form=new Default_Form_User();
		$form->setAction('/user/add');
		$data = $this->_request->isPost() ? $this->_request->getPost() : null;
		if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
			if($data['password'] == $data['password2']) {
				// Get all data when the form is submitted
	
				// Encode password
				$md5_password = md5($data['password']);
				$data['user_password']=$md5_password;
				$data['user_register'] = '1';
	
				// Pass the new values and update the DB
				unset($data['submit']);
				unset($data['password']);
				unset($data['password2']);
				unset($data['id']);
				$user=new Default_Model_Db('user');
				$user->save($data);
				
				/*
				$time = time();
				function sanitize($input) {
					return htmlentities(strip_tags( $input ));
				}
				
				$index = new Zend_Search_Lucene('./tmp/users',true);
				$users = Bootstrap::getDataM('user');
				foreach($users as $user) {
					$doc = new Zend_Search_Lucene_Document();
					$doc->addField(Zend_Search_Lucene_Field::Keyword('screenName',sanitize($user->user_screen_name)));
					$doc->addField(Zend_Search_Lucene_Field::Keyword('email',sanitize($user->user_email)));
					$doc->addField(Zend_Search_Lucene_Field::Keyword('firstName',sanitize($user->user_firstname)));
					$doc->addField(Zend_Search_Lucene_Field::Keyword('lastName',sanitize($user->user_lastname)));
					$doc->addField(Zend_Search_Lucene_Field::Keyword('state',sanitize($user->user_state)));
					$doc->addField(Zend_Search_Lucene_Field::Keyword('zip',sanitize($user->user_zip)));
					$index->addDocument($doc);
				}
				$index->commit();
				*/
				$this->_redirect('/admin/users');
			} else {
				$form->populate($data);
				$this->view->form=$form;
			}
		} else {
			if($data) $form->populate($data);
			$this->view->form=$form;
		}
	}

	public function editAction() {
		if(!Bootstrap::isInGroup('administrator') && !Bootstrap::isInGroup('demo')) {
			$this->_redirect('/user/login/');
		}
		$id = $this->_request->getParam('id',$_SESSION['user_id']);
		$this->view->ck = true;
		$form=new Default_Form_User();
		$form->setAction('/user/edit/');
		$form->removeElement('password');
		$form->removeElement('password2');
		$row = Bootstrap::getDataS('user',"id = $id");
		$data = $this->_request->isPost() ? $this->_request->getPost() : $row->toArray();
		if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
				
			// Get all data when the form is submitted
			$data = $this->_request->getPost();
			unset($data['submit']);
			$data['user_group_id'] = implode(',', $data['user_group_id'] );
			// Pass the new values and update the DB
			$user=new Default_Model_Db('user');
			$user->save($data);
		
			/*
			$time = time();
			function sanitize($input) {
				return htmlentities(strip_tags( $input ));
			}
				
				
			$index = new Zend_Search_Lucene('./tmp/users',true);
			$users = Bootstrap::getDataM('user');
			foreach($users as $user) {
				$doc = new Zend_Search_Lucene_Document();
				$doc->addField(Zend_Search_Lucene_Field::Keyword('screenName',sanitize($user->user_screen_name)));
				$doc->addField(Zend_Search_Lucene_Field::Keyword('email',sanitize($user->user_email)));
				$doc->addField(Zend_Search_Lucene_Field::Keyword('firstName',sanitize($user->user_firstname)));
				$doc->addField(Zend_Search_Lucene_Field::Keyword('lastName',sanitize($user->user_lastname)));
				$doc->addField(Zend_Search_Lucene_Field::Keyword('state',sanitize($user->user_state)));
				$doc->addField(Zend_Search_Lucene_Field::Keyword('zip',sanitize($user->user_zip)));
				$index->addDocument($doc);
			}
			$index->commit();
			*/
			$this->_redirect("/admin/users/");
		}
		// The form is populated from the DB
		$form->populate($data);
		if(Bootstrap::isInGroup('administrator')) {
			if(is_array($data['user_group_id'])) {
				$form->getElement('user_group_id')->setValue($data['user_group_id']);
			}
			else {
				$values = explode(',',$data['user_group_id']);
				$form->getElement('user_group_id')->setValue($values);
			}
		}
		
		$form->setName('Editing_'.$row->user_firstname.'_'.$row->user_lastname);

		$this->view->form=$form;
	}
	public function passresetAction() {
		$this->view->admin = true;
		$this->view->page = 'admin';
		$id = $this->_request->getParam('id');
		$user = $this->_request->getParam('user');
		$this->view->id = $id;
		$this->view->user = $user;
		$length = 7; $strength = 4;
		$vowels = 'aeiouy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEIOUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}

		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		$this->view->password = '';


		$User=new Default_Model_Acl_User();
		$select=new Zend_Db_Table_Select($User);
		$select->where('id = ?', $id);
		$row=$User->fetchRow($select);
		$User2 = new Default_Model_Acl_User($row->acl_user_email, md5($password));
		$User2->updatePassword($id);

		/*Sending E-mail*/
		$body = "Here's your new password:$password\n\nIf you're not sure why your password didn't work, please contact us. We'll figure it out. Otherwise, we have Sherlock Holmes on speed dial. Does that make us Watson? Oh well, we apologize for the inconvenience.";

		$emailSmtpConf = array('auth'=>'login', 'ssl'=>'ssl', 'username'=>'contact@seductiveturtle.com', 'password'=>'p@s5W1rD');

		$transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $emailSmtpConf);

		$protocol = new Zend_Mail_Protocol_Smtp('localhost');
		$protocol->connect();
		$protocol->helo('smtp.gmail.com');

		$transport->setConnection($protocol);

		$mail = new Zend_Mail();
		$mail->setFrom('contact@seductiveturtle.com', 'Seductive Turtle');
		$mail->addTo($user, $user);
		$mail->setSubject('Seductive Turtle Password Reset Tool');
		$mail->setBodyText($body);
		$mail->send($transport);//*/

		$protocol->quit();
		$protocol->disconnect();

	}
	public function removeAction() {

		$this->view->admin = true;
		$this->view->page = 'admin';
		$form=new Default_Form_Acl_User();
		$form->setAction('/acl_user/remove');

		$id=(int) $this->_request->getParam('id');

		$user=new Default_Model_Acl_User();
		$select=new Zend_Db_Table_Select($user);
		$select->where('id = ?', $id);
		$row=$user->fetchRow($select);
		$this->view->email=$row;

		// Pull the username from the DB, and then display a confirmation before deletion
		$thisuser=$row->acl_user_email;
		$this->view->remove="<h2>Administrative User Removal Interface:</h2><br/><br/>";
		$this->view->confirm="Are you sure you want to permanently remove <b>'$thisuser'</b> from Seductive Turtle?<br/><br/>";

		// 9.10.09 Options; Yes (delete entire row for specified user) or No (take us back to the user index page)
		// ?
		// ?

	}

}
?>
