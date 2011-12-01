<?php
class ForumController extends Zend_Controller_Action {
	
	public function init() {

        
        //if (! Bootstrap::isInGroup('administrator')) {
			$this->_redirect('/');
        //}
        //*/

    }
	
	public function indexAction()
	{
        $this->_helper->layout->setLayout("layout-forum");	
		$forum = new Default_Model_Forum_Category();
		$select = new Zend_Db_Table_Select($forum);
		if(isset($_GET['id'])) $select->where('forum_category_id = ?', $_GET['id']);
		else				   $select->where('forum_category_id IS NULL');
		$this->view->data = $select;
		$forumData = $forum->fetchAll($select);
		$this->view->forum = $forumData;
	}
	public function threadAction() {
		$this->_helper->layout->setLayout("layout-forum");
		$posts = array();
		if(!isset($_GET['id'])) {
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
		$post_id = $this->_request->getParam('id');
		$post = new Default_Model_Forum_Post();
		$select = new Zend_Db_Table_Select($post);
		$select->where('id = ?', $post_id);
		$postData = $post->fetchRow($select);
		$posts[count($posts)] = $postData;
		$select = new Zend_Db_Table_Select($post);
		$select->where('forum_post_parent_id = ?', $post_id);
		$postData = $post->fetchAll($select);
		foreach($postData as $post) {
			$posts[count($posts)] = $post;
		}
		$this->view->posts = $posts;
	}
	public function editpostAction() {
		if (! Bootstrap::isInGroup('registered')) {
            $this->_redirect('/');
        }
		$this->_helper->layout->setLayout("layout-forum");
		$form = new Default_Form_Forum_Reply();
		$form->setAction('/forum/editpost/');
		if($this->_request->isPost()) {
			$data['id']						= $this->_request->getParam('id');
			if($this->_request->getParam('forum_post_parent_id') != '') {
				$data['forum_post_parent_id'] 	= $this->_request->getParam('forum_post_parent_id');
			}
			$data['forum_post_forum_category_id'] 	= $this->_request->getParam('forum_post_forum_category_id');
			$data['forum_post_user_id'] 			= $this->_request->getParam('forum_post_user_id');
			$data['forum_post_time'] 				= $this->_request->getParam('forum_post_time');
			$data['forum_post_title'] 				= $this->_request->getParam('forum_post_title');
			$data['forum_post_content'] 			= $this->_request->getParam('forum_post_content');
			$data['forum_post_url']					= 'links/'.$data['forum_post_time'].'.html';
		
			//echo "<pre>".print_r($data,true)."</pre>";
			// @todo redirect to permalink page
			// $this->_redirect('/forum/posts/2009/12/2/some-title.html');
			$post = new Default_Model_Forum_Post();
			$post->save($data);
			
			$this->_redirect('/forum/thread/?cid='.$data['forum_post_forum_category_id'].'&id='.$data['forum_post_parent_id']);
		
		}
		$id = $_GET['id'];
		$post = new Default_Model_Forum_Post();
		$select = new Zend_Db_Table_Select($post);
		$select->where('id = ?', $id);
		$post = $post->fetchRow($select);
		$form->getElement('id')->setValue($id);
		$form->getElement('forum_post_forum_category_id')->setValue($post->forum_post_forum_category_id);
		$form->getElement('forum_post_user_id')->setValue($post->forum_post_user_id);
		$form->getElement('forum_post_time')->setValue(time());
		$form->getElement('forum_post_content')->setValue($post->forum_post_content);
		$form->getElement('forum_post_title')->setValue($post->forum_post_title);
		$form->getElement('forum_post_parent_id')->setValue($post->forum_post_parent_id);
        $this->view->form=$form;
	}
	public function newthreadAction() {
		
		if (! Bootstrap::isInGroup('registered')) {
            $this->_redirect('/');
        }
		$this->_helper->layout->setLayout("layout-forum");
		$form = new Default_Form_Forum_Post();
		$form->setAction('/forum/newthread/');
		if($this->_request->isPost()) {
			$data['forum_post_forum_category_id'] 	= $this->_request->getParam('forum_post_forum_category_id');
			$data['forum_post_user_id'] 			= $this->_request->getParam('forum_post_user_id');
			$data['forum_post_time'] 			= $this->_request->getParam('forum_post_time');
			$data['forum_post_title'] 				= $this->_request->getParam('forum_post_title');
			$data['forum_post_content'] 			= $this->_request->getParam('forum_post_content');
			$data['forum_post_url']					= 'links/'.$data['forum_post_time'].'.html';

			//echo "<pre>".print_r($data,true)."</pre>";
			// @todo redirect to permalink page
			// $this->_redirect('/forum/posts/2009/12/2/some-title.html');
			$post = new Default_Model_Forum_Post();
			$post->save($data);
			
			$this->_redirect('/forum/?cid='.$_GET['cid']);
		
		}
		$form->getElement('forum_post_forum_category_id')->setValue($_GET['cid']);
		$form->getElement('forum_post_user_id')->setValue($_SESSION['user_id']);
		$form->getElement('forum_post_time')->setValue(time());
        $this->view->form=$form;
	}
	public function newreplyAction() {
		
		if (! Bootstrap::isInGroup('registered')) {
            $this->_redirect('/');
        }
		$this->_helper->layout->setLayout("layout-forum");
		$form = new Default_Form_Forum_Reply();
		$form->setAction('/forum/newreply/');
		if($this->_request->isPost()) {
			$data['forum_post_parent_id'] 	= $this->_request->getParam('forum_post_parent_id');
			$data['forum_post_forum_category_id'] 	= $this->_request->getParam('forum_post_forum_category_id');
			$data['forum_post_user_id'] 			= $this->_request->getParam('forum_post_user_id');
			$data['forum_post_time'] 			= $this->_request->getParam('forum_post_time');
			$data['forum_post_title'] 				= $this->_request->getParam('forum_post_title');
			$data['forum_post_content'] 			= $this->_request->getParam('forum_post_content');
			$data['forum_post_url']					= 'links/'.$data['forum_post_time'].'.html';

			//echo "<pre>".print_r($data,true)."</pre>";
			// @todo redirect to permalink page
			// $this->_redirect('/forum/posts/2009/12/2/some-title.html');
			$post = new Default_Model_Forum_Post();
			$post->save($data);
			
			$this->_redirect('/forum/thread/?cid='.$data['forum_post_forum_category_id'].'&id='.$data['forum_post_parent_id']);
		
		}
		$form->getElement('forum_post_parent_id')->setValue($_GET['id']);
		$form->getElement('forum_post_forum_category_id')->setValue($_GET['cid']);
		$form->getElement('forum_post_user_id')->setValue($_SESSION['user_id']);
		$form->getElement('forum_post_time')->setValue(time());
        $this->view->form=$form;
	}
	public function deletepostAction() {
		if (! Bootstrap::isInGroup('registered')) {
            $this->_redirect('/');
        }
		$post = new Default_Model_Forum_Post();
		$post->remove($_GET['id']);
			$this->_redirect('/forum/?id='.$_GET['cid']);
	}
}
?>