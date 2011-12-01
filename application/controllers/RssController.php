<?php

/**
 *
 * Controller for our Dynamic RSS Feed
 *
 * @author Aaron Scherer
 * Suite 38 - 2009
 *
 */

class RssController extends Zend_Controller_Action {

	public function indexAction() {
		// No layout for the feed(s)

			$this->_redirect('/');
		$this->_helper->layout()->disableLayout();

		 
		$rows = Bootstrap::getDataM('blog_post',null,'created_date DESC');
		
		$entries = array();
		foreach($rows as $row) {
			$entry = array();
			$entry['title'] = $row->rss_title;
			$entry['link'] = 'http://'.Bootstrap::getConfig('site','url').'/blog/read/'.$row->permalink;
			$entry['guid'] = 'http://'.Bootstrap::getConfig('site','url').'/blog/read/'.$row->permalink;
			$entry['author'] = Bootstrap::getDataS('user','user_screen_name = "'.$row->author.'"')->user_email ."(".$row->author.")";
			$entry['description'] = $row->rss_description;
			$entry['lastUpdate'] = $row->created_date;
			array_push($entries,$entry);
		}

		$title = 'Suite38 feeds';
		$feedUri = '/rss';

		//link from which feed is available
		$link = 'http://' . Bootstrap::getConfig('site','url') . '/' . $feedUri;


		//create array according to structure defined in Zend_Feed documentation
		$rss = array('title' => $title,
	                  'link'  => $link,
	                  'description' => $title,
	                  'language' => 'en-us',
	                  'charset' => 'ISO-8859-1',
	                  'entries' => $entries
		);


		$feedObj = Zend_Feed::importArray($rss,'rss');


		$feedObj->send();
		
	}

}
