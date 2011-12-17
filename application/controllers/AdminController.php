<?php

class AdminController extends Zend_Controller_Action {

	public function init()
	{
		if (! Bootstrap::isInGroup('administrator')) {
			$this->_redirect('/user/login');
		}
		$this->view->pageTitle = "Admin Panel";
		$this->view->admin = true;
		$this->view->page = 'admin';
	}

	public function indexAction()
	{
		$this->_redirect("/admin/dashboard");
	}

	public function dashboardAction() {
		// @todo add analytics functionity and a better menu
		// This is out management portal, and will be the same for our clients
		include Bootstrap::getConfig('site','base_dir').'/includes/google_api/googleanalytics.class.php';

		// enter your login, password and id into the variables below to try it out
		$login = Bootstrap::getConfig('analytics','username');
		$password = Bootstrap::getConfig('analytics','password');
		$id=Bootstrap::getConfig('analytics','profile_id');

		// NOTE: the id is in the form ga:12345 and not just 12345
		// if you do e.g. 12345 then no data will be returned
		// read http://www.electrictoolbox.com/get-id-for-google-analytics-api/ for info about how to get this id from the GA web interface
		// or load the accounts (see below) and get it from there
		// if you don't specify an id here, then you'll get the "Badly formatted request to the Google Analytics API..." error message

	
		// retrieve information from google analytics 
		$stringVisits = '';
		$stringViews = '';
		if(class_exists('GoogleAnalytics')) {
			$ga = new GoogleAnalytics($login,$password);
			$ga->setProfile($id);
			$ga->setDateRange('2009-01-01',date('Y-m-d'));
			@$report = $ga->getReport(
			array('dimensions'=>urlencode('ga:date'),
					'metrics'=>urlencode('ga:pageviews,ga:visits'),
				)
			);
	
			foreach($report as $date=>$values){
				
				$visits = $values['ga:pageviews'];
				$views = $values['ga:visits'];
				
				$stringVisits .= "$date-$visits,";
				$stringViews .= "$date-$views,";
			}
			$stringVisits = substr($stringVisits,0,-1);
			$stringViews = substr($stringViews,0,-1);
		}
		$this->view->visits = $stringVisits;
		$this->view->views = $stringViews;
		

	}
	public function gaAction()
	{
		$this->_helper->layout->disableLayout();
	}

	public function newpageAction() {
		$this->view->ck = true;
		// @todo new page functionality

		if($this->_request->isPost()) {
			$data = array();
			// If the form is being submitted gather data and record it to DB
			$data['page_title'] = $this->_request->getPost('page_title');
			$data['page_code'] = $this->_request->getPost('page_code');
			$data['page_name'] = $this->_request->getPost('page_name');
			$data['page_content'] = $this->_request->getPost('page_content');
			$data['page_meta_keywords'] = $this->_request->getPost('page_meta_keywords');
			$data['page_meta_description'] = $this->_request->getPost('page_meta_description');

			$user=new Default_Model_Db('page');
			$user->save($data);

			$this->_redirect('/admin/pageedit');
		}
		else {
			$pageForm = new Default_Form_Admin_Pageedit();
			$pageForm->setAction("/admin/newpage");
			$this->view->pageForm=$pageForm;
		}
	}

	public function pageeditAction() {
		$this->view->ck = true;
		// Check to see if a page id is given in the URL
		if($this->_request->getParam('id')) {
			// Check to see if the form is being submitted or not
			if($this->_request->isPost()) {
				$data = array();
				$data = $this->_request->getPost();
				unset($data['submit']);
				$data['page_update_time'] = time();

					
				$data2 = Bootstrap::getDataS('page','id = '.$data['id']);
				$data2 = $data2->toArray();
				foreach($data2 as $key=>$value) { $data['_origData'][$key] = $value; }

				$user=new Default_Model_Db('page');
				$user->save($data);

				$this->_redirect('/admin/pageedit');
			}
			else {
				// CMS layout to integrate CKeditor and pull content to appear like the live site

				// Retrieve the ID from the requested URL
				$page_id = $this->_request->getParam('id');
				$this->view->page_id = $page_id;

				// Using the requested ID pull DB information for that page
				$content = Bootstrap::getDataS('page', 'id = '.$page_id);

				// Build the Page Edit form
				$pageForm = new Default_Form_Admin_Pageedit();
				$pageForm->setAction("/admin/pageedit");

				// Set values in the form from the DB information
				$pageForm->getElement('id')->setValue($page_id);
				$pageForm->getElement('page_title')->setValue($content->page_title);
				$pageForm->getElement('page_code')->setValue($content->page_code);
				$pageForm->getElement('page_name')->setValue($content->page_name);
				$pageForm->getElement('page_content')->setValue(stripslashes($content->page_content));
				$pageForm->getElement('page_meta_keywords')->setValue($content->page_meta_keywords);
				$pageForm->getElement('page_meta_description')->setValue(stripslashes($content->page_meta_description));
				$pageForm->getElement('page_update_time')->setValue($content->page_update_time);

				$this->view->pageForm=$pageForm;
			}
		}
		else {
			// If no page ID is requested we are at the editor index
			// Pull all pages in the DB and display them
			$rows = Bootstrap::getDataM('page');
		
			$paginator = Zend_Paginator::factory($rows);
			$paginator->setItemCountPerPage(10)->setCurrentPageNumber($this->_request->getParam('page'));
			$this->view->pages = $paginator;
		}

	}

	public function pagedeleteAction() {
		// @todo page delete functionality
		echo "This is for deleting pages!";
	}

	/* IMAGE CMS FUNCTIONS */
	public function configAction() {

		// CMS layout to integrate FCKeditor and pull content to appear like the live site
		//$this->_helper->layout->setLayout("layout-admin");
		$this->_helper->layout->disableLayout();
		$pageForm = new Default_Form_Admin_Config();
		$pageForm->setAction("/admin/configsave");
		$this->view->pageForm=$pageForm;

	}
	public function configsaveAction() {
        $this->_helper->layout->disableLayout();
		if($this->_request->isPost()) {
			$data = array();
			// Get all data when the form is submitted
			$params = $this->_request->getPost();
			unset($params['submit']);
			
			foreach($params as $key => $value) {
				$element = explode('__',$key);
				$data[$element[0]][$element[1]] = $value;
				if($element[1] == 'password' && strlen($value) < 1) unset($data[$element[0]][$element[1]]);
			}
			$config = new Default_Model_Config();
			$config->save($data);
			$this->_redirect('/admin/dashboard');
		}
	}
	public  function usersAction() {
		$q = $this->_request->getParam('q',null);
		$users = empty($q) ? Bootstrap::getDataM('user') : Bootstrap::getDataM('user',"user_screen_name LIKE '%$q%' OR user_email LIKE '%$q%' OR user_firstname LIKE '%$q%' OR user_lastname");
		$paginator = Zend_Paginator::factory($users);
		$paginator->setItemCountPerPage(7)->setCurrentPageNumber($this->_request->getParam('page'));
		$this->view->users = $paginator;
		$this->view->q = $q;
	}

	public function licenseAction() {
		$sites = ""; 
	}

}

?>
