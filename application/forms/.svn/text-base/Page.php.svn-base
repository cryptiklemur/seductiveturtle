<?php

class Default_Form_User extends Zend_Form
{
     public function init(){
		$this->setName('New Page');
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

            $id = new Zend_Form_Element_Hidden('id');
            $this->addElement($id);
			
            $page_code = new Zend_Form_Element_Text('page_code');
            $page_code->setLabel('Page Code');
            $this->addElement($page_code);
			
            $page_name = new Zend_Form_Element_Text('page_cname');
            $page_name->setLabel('Page Name');
            $this->addElement($page_name);
			
            $page_content = new Zend_Form_Element_Textarea('content');
            $page_content->setLabel('Page Content');
            $this->addElement($page_content);
			
            $page_title = new Zend_Form_Element_Text('page_title');
            $page_title->setLabel('Page Title');
            $this->addElement($page_title);
			
            $page_meta_keywords = new Zend_Form_Element_Text('page_meta_keywords');
            $page_meta_keywords->setLabel('Page Meta Keywords');
            $this->addElement($page_meta_keywords);
			
            $page_meta_description = new Zend_Form_Element_Text('page_meta_description');
            $page_meta_description->setLabel('Page Meta Description');
            $this->addElement($page_meta_description);
			
            $menu_name = new Zend_Form_Element_Text('menu_name');
            $menu_name->setLabel('Menu Name');
            $this->addElement($menu_name);
			
            $menu_alt = new Zend_Form_Element_Text('menu_alt');
            $menu_alt->setLabel('Menu alt');
            $this->addElement($menu_alt);
			
            $menu_link = new Zend_Form_Element_Text('menu_link');
            $menu_link->setLabel('Menu Link');
            $this->addElement($menu_link);
			
            $menu_class = new Zend_Form_Element_Text('menu_class');
            $menu_class->setLabel('Menu Class');
            $this->addElement($menu_class);

            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setLabel('Submit');
            $this->addElement($submit);

            $this->addDisplayGroup(array('user_screen_name', 'user_email','user_firstName', 'user_lastName','user_city','user_state','user_zip','user_phone', 'user_country', 'submit', 'id'),'editUser',array('class' =>'editUserField', 'legend' => 'Edit User'));

            return $this;

     }
}

?>