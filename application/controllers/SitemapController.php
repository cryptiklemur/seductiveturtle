<?php

class SitemapController extends Zend_Controller_Action {

	// This is the Action called by /sitemap.xml... dynamically creates the xml sitemap upon request
	//
	public function indexAction()
    {
			$this->_redirect('/');
        $this->_helper->layout()->disableLayout();
		
		$urls = array();
       
		$post = new Default_Model_Blog_Post();
		$select = new Zend_Db_Table_Select($post);
		$rows1 = $post->fetchAll($select);
		
		foreach($rows1 as $row) {
			$i = 0;
			$urls[] = array('loc'=>'http://'.$_SERVER['HTTP_HOST'].'/blog/read/'.$row->permalink, 'lastmod'=>date('c',$row->created_date), 'changefreq'=>'daily','priority'=>'1.0');
			$comment = new Default_Model_Blog_Comment();
			$select = new Zend_Db_Table_Select($comment);		
	        $select->where('post_id = ?', $row->id);
			$rows2 = $comment->fetchAll($select);
			foreach($rows2 as $row2) {
				$urls[] = array('loc'=>'http://'.$_SERVER['HTTP_HOST'].'/blog/read/'.$row->permalink."#comment_header_".$row->category,'lastmod'=>date('c',$row2->date), 'changefreq'=>'daily','priority'=>'1.0');
			}
		}
		
		
		$page = new Default_Model_Page();
		$select = new Zend_Db_Table_Select($page);
		$rows3 = $page->fetchAll($select);
		
		// @todo fist lastmod time here to display the future 'last update time' for cms_page
		foreach($rows3 as $row) {
			$urls[] = array('loc'=>'http://'.$_SERVER['HTTP_HOST'].'/'.$row->page_code, 'lastmod'=>date('c',$row->page_update_time), 'changefreq'=>'daily','priority'=>'1.0');
		}
		
		
        //$urls = array(array('loc'=>'http://www.websitecruiser.com/', 'lastmod'=>'2009-04-02T11:34:48+00:00', 'changefreq'=>'daily', 'priority'=>'1.0'));
        //*/
        $this->view->urls = $urls;
		header('Content-Type: text/xml');
    }
}
