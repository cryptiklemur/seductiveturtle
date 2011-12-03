<?php
class IndexController extends Zend_Controller_Action {
	public function init() {
		$front = Zend_Controller_Front::getInstance();
	}

	public function indexAction() {
		if($_SERVER['REMOTE_ADDR'] == '76.88.61.48')
			$this->_helper->layout->setLayout('newlayout');
		// Grab the URI after "http://www.DOMAIN.com"
		$server_uri = $_SERVER['REQUEST_URI'];
		// If we are at the index (homepage) of the site:
		if ($server_uri == '/') {
			//$this->_redirect('/home');

			// Load the homepage
			$row = Bootstrap::getDataS('page','page_code = "home"');

			// Set ID and Name variables
			$page_id = $row->id;
			$page_name = $row->page_name;
			
			// Format HTML for display
			$raw_content = stripslashes($row->page_content);
			// Execute PHP code from the page
			// This is to echo $div_content (set above)
			$content = eval('?>'.$raw_content.'<?');

			// Send content to the view(s)
			$this->view->content = $content;
			$this->view->page_name = $row->page_name;

			if (strlen($row->page_title) > 2) {
				$this->view->pageTitle = $row->page_title;
			}
			if (strlen($row->page_meta_keywords) > 2) {
				$this->view->metaKeywords = $row->page_meta_keywords;
			}
			if (strlen($row->page_meta_description) > 2) {
				$this->view->metaDescription = $row->page_meta_description;
			}
		}
		else {
			$errors = $this->_getParam('error_handler');
			$message = '';

			// Error (processes pages in the URI that are not controllers)
			switch ($errors->type) {
				case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
					$params = $errors->request->getParams();
					$page_code = $params['controller']; //page_code=controller_name

					$server_name = $_SERVER['SERVER_NAME'];
					$this->view->server_name = $server_name;

					// These get set later
					$content = null;
					$info = null;

					// If page code isnt home or none
					if ($page_code != 'home' && $page_code != 'none') {

						// Pull that page data from the DB
						$row = Bootstrap::getDataS('page','page_code = "'.$page_code.'"');
						// Set ID and Name variables
						$page_id = $row->id;
						$page_name = $row->page_name;

						// If there is information for that page code in the DB:
						if ($row != null) {
							// Format HTML for display
							$raw_content = stripslashes($row->page_content);
							// Execute PHP code from the page
							// This is to echo $div_content (set above)
							$content = eval('?>'.$raw_content.'<?');

							// Send that content to the views
							$this->view->content = $content;
							$this->view->page_name = $row->page_name;

							if (strlen($row->page_title) > 2) {
								$this->view->pageTitle = $row->page_title;
							}
							if (strlen($row->page_meta_keywords) > 2) {
								$this->view->metaKeywords = $row->page_meta_keywords;
							}
							if (strlen($row->page_meta_description) > 2) {
								$this->view->metaDescription = $row->page_meta_description;
							}

							// If there was NO information for that page code
							// Error page not found
						} else {
							Default_Model_Logger::log("error/error: page not found: $page_name");
							$this->_redirect('/');
						}
						$this->view->info = $info;
					}
					break;

				case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

					// 404 error -- controller or action not found
					$this->getResponse()->setHttpResponseCode(404);
					//$message = 'Page not found';
					$exception = $errors->exception;
					$message = "An error occurred\n$messsage\n\nException information:\nMessage: ".$exception->getMessage()."\nStack trace:\n".$exception->getTraceAsString()."\n\n";
					Default_Model_Logger::log($message);
					echo $message;
					break;
				default:
					// application error
					$this->getResponse()->setHttpResponseCode(500);
					$message = 'Application error';
					$exception = isset($errors->exception) ? $errors->exception : null;
					$mess = is_null($exception) ? 'no message' : $exception->getMessage();
					$trace = is_null($exception) ? 'no message' : $exception->getTraceAsString();
					$message = "An error occurred\n$messsage\n\nException information:\nMessage: ".$mess."\nStack trace:\n".$trace."\n\n";
					if(!is_null($exception)) {
						echo $message;
						Default_Model_Logger::log($message);
					}

					break;

			}
		}
	}
	public function errorAction() {
	}
	public function emailAction() {
		if ($this->_request->isPost()) {

			foreach($this->_request->getPost() as $k=>$v) { $$k=$v; }
			$message="Name: $name\nEmail: $email\nMessage:\n\n".$message;

			$send_from_name= $name;
			$send_from_email="no-reply@galacticedge.com";
			$header="From: $name <$email>\r\n";

			//$params = "-oi -f $send_from_email";
			$params = "-f $email";

			$recipient="info@galacticedge.com";

			$emailSmtpConf = array(
                    'auth' => 'login',
                    'ssl' => 'tls',
                    'username' => 'no-reply@galacticedge.com',
                    'password' => 'sld6Nzqq!'
                    );

                    $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $emailSmtpConf);

                    $mail = new Zend_Mail();
                    $mail->setFrom($send_from_email, $send_from_name);
                    $mail->addTo($recipient, '');
                    $mail->setSubject('Contact Form');
                    $mail->setBodyText($message);
                    $mail->send($transport);//*/

                    $transport->__destruct();

                    $this->_redirect('/contact/?msg=sent');

		} else {
			$msg=$this->_request->getParam('msg');
			if (strlen($msg) >2) {
				$this->view->message="Contact form $msg";
				$this->view->page_name="Message Sent";
			} else {
				$this->view->page_name="Contact Us";
			}

		}
	}
	public function trackingAction() {
		$this->_helper->layout->disableLayout();
		//Bootstrap::pr($_SERVER);
		Bootstrap::pr($_REQUEST);
		$ip = $_SERVER['REMOTE_ADDR'];
		$date = date('Y-m-d H:i:s');
		$already = Bootstrap::getDataM('tracking',"RemoteAddress LIKE '$ip' AND timestamp LIKE '".date('Y-m-d H:')."%'");
		//Bootstrap::pr($already);
		$count = 0;
		foreach($already as $item) $count++;
		if($count < 1) {
			$tracking = new Default_Model_Db('tracking');
			$data = array();
			$data['Referer'] = $_REQUEST['referer'];
			$data['DestinationUrl'] = $_SERVER['HTTP_REFERER'];
			$data['UserAgent'] = $_REQUEST['useragent'];
			$data['RemoteAddress'] = $ip;
			$data['RemotePort'] = $_SERVER['REMOTE_PORT'];
			$data['timestamp'] = $date;
			$tracking->save($data, true);
			echo "added";
		} else { 
			echo "Already added";
		}
	}
}
?>
