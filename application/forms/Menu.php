<?php

class Default_Form_Menu extends Zend_Form
{
     public function init(){

        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('id', 'menu_form');

		$id = new Zend_Form_Element_Hidden('id');
		$this->addElement($id);
		
		$menu_name = new Zend_Form_Element_Text('name');
		$menu_name->setLabel('Menu Name');
		$this->addElement($menu_name);

		$menu_alt = new Zend_Form_Element_Text('alt');
		$menu_alt->setLabel('Menu alt');
		$this->addElement($menu_alt);

		$menu_link = new Zend_Form_Element_Text('link');
		$menu_link->setLabel('Menu Link');
		$this->addElement($menu_link);

		$menu_visible = new Zend_Form_Element_Radio('visible');
		$menu_visible->setLabel('Visible')
					 ->addMultiOptions(array(
						'0' =>'No',
						'1' => 'Yes'
					))
					 ->setSeparator('&nbsp;');
		$this->addElement($menu_visible);
		
		$menu_order = new Zend_Form_Element_Text('order');
		$menu_order->setLabel('Menu Position');
		$this->addElement($menu_order);

		$menu_type = new Zend_Form_Element_Radio('type');
		$menu_type->setLabel('Type')
					 ->addMultiOptions(array(
						'front' => 'Front End',
						'admin' =>'Back End'
					))
					 ->setSeparator('&nbsp;');
		$this->addElement($menu_type);


		foreach($this->getElements() as $element) {
			$element->removeDecorator('HtmlTag')
					->removeDecorator('Label')
					->addDecorator('Label')
					->setAttrib('class','trigger')
					->addDecorator('Description', array('id'=>'button_html-'.$element->getName(), 'tag'=>'div','style'=>'display:none'));
		}
		
		$array = array();
		foreach($this->getElements() as $element) {
			$array[] = $element->getName();
		}
		$this->addDisplayGroup($array, 'menu', array(
			'class'=>'fields menuField', 'legend' => 'Edit Menu Item', 'id' => 'menu'
		));
		$this->removeDecorator('DtDdWrapper');
		return $this;

     }
}

?>