<?php 
class Default_Form_Admin_Divedit extends Zend_Form {
    public function init() {
    
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        
        $id = new Zend_Form_Element_Hidden('id');
        $this->addElement($id);
        
        $parent_page_id = new Zend_Form_Element_Text('parent_page_id');
		$parent_page_id->setLabel('Div Parent Page ID');
        $this->addElement($parent_page_id);
		
		$name = new Zend_Form_Element_Text('name');
        $name->setLabel('Div Name');
        $this->addElement($name);
        
        $css_id = new Zend_Form_Element_Text('css_id');
        $css_id->setLabel('Div Style ID');
        $this->addElement($css_id);
        
        $css_class = new Zend_Form_Element_Text('css_class');
        $css_class->setLabel('Div Style Class');
        $this->addElement($css_class);
        
        $content = new Zend_Form_Element_Textarea('content');
        $content->setLabel('Div Content');
        $this->addElement($content);
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');
        $this->addElement($submit);

        $this->addDisplayGroup(array('id', 'parent_page_id', 'name', 'css_id', 'css_class','content','submit'), 'Divedit', array('class'=>'DiveditField', 'legend'=>'Page Div Editor'));

        return $this;

    }
}

?>
