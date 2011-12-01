<?php
class Default_Form_Admin_Pageedit extends Zend_Form {
	public function init() {

		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');

		$id = new Zend_Form_Element_Hidden('id');
		$this->addElement($id);

		$page_title = new Zend_Form_Element_Text('page_title');
		$page_title->setLabel('Page Title');
		$this->addElement($page_title);

		$page_code = new Zend_Form_Element_Text('page_code');
		$page_code->setLabel('Page Code');
		$this->addElement($page_code);

		$page_name = new Zend_Form_Element_Text('page_name');
		$page_name->setLabel('Page Name');
		$this->addElement($page_name);

		$page_content = new Zend_Form_Element_Textarea('page_content');
		$page_content->setLabel('Page Content')->setAttrib('id','ck_replace');
		$this->addElement($page_content);

		$page_meta_keywords = new Zend_Form_Element_Text('page_meta_keywords');
		$page_meta_keywords->setLabel('Page Keywords');
		$this->addElement($page_meta_keywords);

		$page_meta_description = new Zend_Form_Element_Text('page_meta_description');
		$page_meta_description->setLabel('Page Description');
		$this->addElement($page_meta_description);

		 $page_update_time = new Zend_Form_Element_Text('page_update_time');
		 $page_update_time->setLabel('Page Update Time');
		 $this->addElement($page_update_time);

		 foreach($this->getElements() as $element) {
		 	$element->removeDecorator('HtmlTag')
		 	->removeDecorator('Label')
		 	->addDecorator('Label')
		 	->setAttrib('class','trigger')
		 	->addDecorator('Description', array('id'=>'button_html-'.$element->getName(), 'tag'=>'div','style'=>'display:none'));
		 }

		 $this->addDisplayGroup(array('page_title', 'page_code', 'page_name'), 'Pageedit1', array('class'=>'fields PageeditField1', 'legend'=>'Page Editor', 'id'=>'Pageedit1'));
		 $this->addDisplayGroup(array('page_meta_keywords', 'page_meta_description'), 'Pageedit2', array('class'=>'fields PageeditField2', 'id'=>'Pageedit2'));
		 $this->addDisplayGroup(array('page_content','id'), 'Pageedit3', array('class'=>'fields PageeditField3', 'id'=>'Pageedit3'));

		 return $this;

	}
}

?>
