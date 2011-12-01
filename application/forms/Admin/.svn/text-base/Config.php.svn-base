<?php
class Default_Form_Admin_Config extends Zend_Form {
    public function init() {

    	$this->setName('Website_Configuration');
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        $configItem = Bootstrap::getDataM('config','config_element_type IS NOT NULL');

        $elementArray = array();
        $keys = array();
        foreach($configItem as $item) {
                switch($item->config_element_type) {
                        case 'text':
                                $element = new Zend_Form_Element_Text($item->config_section."__".$item->config_name);
                                $element->setLabel($item->config_display);
                                $value = isset($item->config_current_value) ? $item->config_current_value : $item->config_default_value;
                                $element->setValue($value)
          								->setAttrib('alt',$item->config_element_description);
                                $this->addElement($element);
                                $elementArray[] = $item;
                                if(!array_key_exists($item->config_section, $keys)) $keys[$item->config_section] = $item->config_section;
                                break;
                        case 'color':
                                $element = new Zend_Form_Element_Text($item->config_section."__".$item->config_name);
                                $element->setLabel($item->config_display);
                                $value = isset($item->config_current_value) ? $item->config_current_value : $item->config_default_value;
                                $element->setValue($value)
          								->setAttrib('alt',$item->config_element_description);
                                $this->addElement($element);
                                $elementArray[] = $item;
                                if(!array_key_exists($item->config_section, $keys)) $keys[$item->config_section] = $item->config_section;
                                break;
                        case 'price':
                                $element = new Zend_Form_Element_Text($item->config_section."__".$item->config_name);
                                $element->setLabel($item->config_display . " (in dollars)");
                                $value = isset($item->config_current_value) ? $item->config_current_value : $item->config_default_value;
                                $element->setValue($value)
          								->setAttrib('alt',$item->config_element_description);
                                $this->addElement($element);
                                $elementArray[] = $item;
                                if(!array_key_exists($item->config_section, $keys)) $keys[$item->config_section] = $item->config_section;
                                break;
                        case 'password':
                                $element = new Zend_Form_Element_Password($item->config_section."__".$item->config_name);
                                $element->setLabel($item->config_display);
                                $value = isset($item->config_current_value) ? $item->config_current_value : $item->config_default_value;
                                $element->setValue($value)
          								->setAttrib('alt',$item->config_element_description);
                                $this->addElement($element);
                                $elementArray[] = $item;
                                if(!array_key_exists($item->config_section, $keys)) $keys[$item->config_section] = $item->config_section;
                                break;
                        case 'time':
                                $element = new Zend_Form_Element_Select($item->config_section."__".$item->config_name);
                                $element->setLabel($item->config_display);
                                $value = isset($item->config_current_value) ? $item->config_current_value : $item->config_default_value;
                                $element->addMultiOptions(array(
												'60*60' => '1 Hour',
												'60*60*6' =>'6 Hours',
												'60*60*12' =>'12 Hours',
												'60*60*24' =>'1 Day',
												'60*60*24*7' =>'1 Week',
												'60*60*24*31' =>'1 Month',
												'60*60*24*31*52' =>'1 Year',
												'60*60*24*31*52*999999' =>'Forever'
											))
										->setValue($value)
          								->setAttrib('alt',$item->config_element_description);
                                $this->addElement($element);
                                $elementArray[] = $item;
                                if(!array_key_exists($item->config_section, $keys)) $keys[$item->config_section] = $item->config_section;
                                break;
                        case 'radio':
                                $element = new Zend_Form_Element_Radio($item->config_section."__".$item->config_name);
                                $element->setLabel($item->config_display);
                                $value = isset($item->config_current_value) ? $item->config_current_value : $item->config_default_value;
                                $element->addMultiOptions(array(
												'true' => 'True',
												'false' =>'False'
											))
										->setSeparator('&nbsp;')
										->setValue($value)
          								->setAttrib('alt',$item->config_element_description);
                                $this->addElement($element);
                                $elementArray[] = $item;
                                if(!array_key_exists($item->config_section, $keys)) $keys[$item->config_section] = $item->config_section;
                                break;
                        case 'textarea':
                                $element = new Zend_Form_Element_Textarea($item->config_section."__".$item->config_name);
                                $element->setLabel($item->config_display);
                                $value = isset($item->config_current_value) ? $item->config_current_value : $item->config_default_value;
                                $element->setValue($value)
                                		->setRequired(true)
                                		->setAttrib('wrap','soft')
          								->setAttrib('alt',$item->config_element_description);                                
                                $this->addElement($element);
                                $elementArray[] = $item;
                                if(!array_key_exists($item->config_section, $keys)) $keys[$item->config_section] = $item->config_section;
                                break;
                        case 'default':
                                break;
                }
        }
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');
        $this->addElement($submit);
        
    	foreach($this->getElements() as $element) {
			$element->removeDecorator('HtmlTag')->removeDecorator('Label')->addDecorator('Label');
    	}
        $submit->removeDecorator('Label');
        $count = 0;
        foreach($keys as $key) {
                $items = array();
                foreach($elementArray as $elementItem) {
                        if($elementItem->config_section == $key) {
                                $items[] = $elementItem->config_section."__".$elementItem->config_name;
                        }
                }
                        $items[] = 'submit';
                $this->addDisplayGroup($items,$count++ , array('class'=>'fields configEditField', 'legend'=>$key, 'id' => $key));
        }

        return $this;

    }
}

?>
