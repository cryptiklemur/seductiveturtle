<?php

class Default_Form_Faq extends Zend_Form
{
     public function init(){
		$this->setName('New_F.A.Q_Item');
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

            $id = new Zend_Form_Element_Hidden('id');
            $this->addElement($id);
			
            $faq_title = new Zend_Form_Element_Text('faq_title');
            $faq_title->setLabel('Title')->setRequired(true);
            $this->addElement($faq_title);
			
            $faq_content = new Zend_Form_Element_Textarea('faq_content');
            $faq_content->setLabel('Content')->setRequired(true);
            $this->addElement($faq_content);

            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setLabel('Submit');
            $this->addElement($submit);

            $this->addDisplayGroup(array('faq_title', 'faq_content', 'submit', 'id'),'faqItem',array('class' =>'faqField'));

            return $this;

     }
}

?>