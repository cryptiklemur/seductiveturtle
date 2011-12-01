<?php

class Default_Form_Wcs extends Zend_Form
{
     public function init(){

        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('id', 'menu_form');

		$id = new Zend_Form_Element_Hidden('id');
		$this->addElement($id);
		
		$wcs_name = new Zend_Form_Element_Text('name');
		$wcs_name->setLabel('Race Name');
		$this->addElement($wcs_name);
		
		$wcs_req_level = new Zend_Form_Element_Text('req_level');
		$wcs_req_level->setLabel('Race Required Level')->addValidator('digits');
		$this->addElement($wcs_req_level);

		$wcs_max_level = new Zend_Form_Element_Text('max_level');
		$wcs_max_level->setLabel('Race Max Level')->addValidator('digits');
		$this->addElement($wcs_max_level);

		$i = 0;
		for($i = 1; $i <= 10; $i++) {
			
			$wcs_skill_name = new Zend_Form_Element_Text("skill_".$i."_name");
			$wcs_skill_name->setLabel("WCS Skill $i Name");
			$this->addElement($wcs_skill_name);
			
			$wcs_skill_level = new Zend_Form_Element_Text("skill_".$i."_level");
			$wcs_skill_level->setLabel("WCS Skill $i Level")->addValidator('digits');
			$this->addElement($wcs_skill_level);
			
			$wcs_skill_notes = new Zend_Form_Element_Textarea("skill_".$i."_notes");
			$wcs_skill_notes->setLabel("WCS Skill $i Notes")->setAttrib('id','wcsTA');
			$this->addElement($wcs_skill_notes);
			
		}

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