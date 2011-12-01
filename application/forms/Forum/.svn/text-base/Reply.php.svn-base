<?php

class Default_Form_Forum_Reply extends Zend_Form
{
     public function init(){
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

            $id = new Zend_Form_Element_Hidden('id');
            $this->addElement($id);
			
            $parent_id = new Zend_Form_Element_Hidden('forum_post_parent_id');
            $this->addElement($parent_id);
			
            $forum_category_id = new Zend_Form_Element_Hidden('forum_post_forum_category_id');
            $this->addElement($forum_category_id);
			
            $forum_id = new Zend_Form_Element_Hidden('forum_post_forum_id');
            $this->addElement($forum_id);
			
            $user_id = new Zend_Form_Element_Hidden('forum_post_user_id');
            $this->addElement($user_id);
			
            $time = new Zend_Form_Element_Hidden('forum_post_time');
            $this->addElement($time);
						
            $title = new Zend_Form_Element_Text('forum_post_title');
            $title->setLabel("Post Title");
            $this->addElement($title);
			
            $content = new Zend_Form_Element_Textarea('forum_post_content');
            $content->setLabel("Post Content");
            $this->addElement($content);

            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setLabel('Submit');
            $this->addElement($submit);

            $this->addDisplayGroup(array('forum_post_parent_id', 'forum_post_forum_category_id','forum_post_forum_id', 'forum_post_user_id','forum_post_time','forum_post_title','forum_post_content', 'submit', 'id'),'newPost',array('class' =>'newReplyField', 'legend' => 'New Post'));

            return $this;

     }
}

?>
