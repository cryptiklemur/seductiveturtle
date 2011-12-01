<?php

class Default_Form_Forum_Post extends Zend_Form
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
			
            $user_screen_name = new Zend_Form_Element_Hidden('forum_post_user_screen_name');
            $this->addElement($user_screen_name);
			
            $title = new Zend_Form_Element_Text('forum_post_title');
            $title->setLabel("Thread Title");
            $this->addElement($title);
			
            $content = new Zend_Form_Element_Textarea('forum_post_content');
            $content->setLabel("Thread Content");
            $this->addElement($content);

            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setLabel('Submit');
            $this->addElement($submit);

            $this->addDisplayGroup(array('forum_post_parent_id', 'forum_post_forum_category_id','forum_post_forum_id', 'forum_post_user_id','forum_post_time','forum_post_user_screen_name','forum_post_title','forum_post_content', 'submit', 'id'),'newPost',array('class' =>'newPostField', 'legend' => 'New Post'));

            return $this;

     }
}

?>
