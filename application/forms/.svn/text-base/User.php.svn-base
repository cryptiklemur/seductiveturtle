<?php

class Default_Form_User extends Zend_Form
{
     public function init(){

        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
            
            $filterTrim = new Zend_Filter_StringTrim();

            $emailValidator = new Zend_Validate_EmailAddress(Zend_Validate_Hostname::ALLOW_DNS, false);
            $emailValidator->setMessage(__('Invalid E-mail'));
            
            $validatorUniqueEmail = new Zend_Validate_Db_NoRecordExists('user', 'user_email');
            $validatorUniqueEmail->setMessage('Email already in use. Please select another email');
            
            $validatorUniqueScreenName = new Zend_Validate_Db_NoRecordExists('user', 'user_screen_name');
            $validatorUniqueScreenName->setMessage('Screen Name already in use. Please select another screen name');
			

            $id = new Zend_Form_Element_Hidden('id');
            $this->addElement($id);
			
            $user_screen_name = new Zend_Form_Element_Text('user_screen_name');
            $user_screen_name->setLabel('Screen Name')->setRequired(true);
            $this->addElement($user_screen_name);

            $user_email = new Zend_Form_Element_Text('user_email');
            $user_email->setLabel('Email')->setRequired(true)->addValidator($emailValidator, true);
            $this->addElement($user_email);
            
            $password = new Zend_Form_Element_Password('password');
            $password->setLabel('Password')
			->setRequired(true)
			->addValidator( new Zend_Validate_StringLength(5));
            $this->addElement($password);
            
            $password2 = new Zend_Form_Element_Password('password2');
            $password2->setLabel('Confirm Password')
			->setRequired(true)->addValidator( new Zend_Validate_StringLength(5));
            $this->addElement($password2);
			
			if(Bootstrap::isInGroup('administrator') || Bootstrap::isInGroup('accountant')) {
				$user_group_id = new Zend_Form_Element_Multiselect('user_group_id');
				$user_group_id->setLabel('User Type(s)');
				$groups = Bootstrap::isInGroup('administrator') ? Bootstrap::getDataM('group') : Bootstrap::getDataM('group','enabled = 1');
				$selectGroups = array();
				foreach($groups as $group) {
					$selectGroups[$group->id] = $group->group_name;
				}
				$user_group_id->setMultiOptions($selectGroups);
				$this->addElement($user_group_id);
			}
			
            $user_firstName = new Zend_Form_Element_Text('user_firstname');
            $user_firstName->setLabel('First Name');
            $this->addElement($user_firstName);

            $user_lastName = new Zend_Form_Element_Text('user_lastname');
            $user_lastName->setLabel('Last Name');
            $this->addElement($user_lastName);

            $user_position = new Zend_Form_Element_Text('user_position');
            $user_position->setLabel('Position');
            $this->addElement($user_position);

            $user_address_1 = new Zend_Form_Element_Text('user_address_1');
            $user_address_1->setLabel('Address 1');
            $this->addElement($user_address_1);
			
            $user_address_2 = new Zend_Form_Element_Text('user_address_2');
            $user_address_2->setLabel('Address 2');
            $this->addElement($user_address_2);

            $user_city = new Zend_Form_Element_Text('user_city');
            $user_city->setLabel('City');
            $this->addElement($user_city);

            $user_city = new Zend_Form_Element_Text('user_city');
            $user_city->setLabel('City');
            $this->addElement($user_city);

            $user_state = new Zend_Form_Element_Text('user_state');
            $user_state->setLabel('State');
            $this->addElement($user_state);

            $user_zip = new Zend_Form_Element_Text('user_zip');
            $user_zip->setLabel('Zip Code');
            $this->addElement($user_zip);

            $user_phone = new Zend_Form_Element_Text('user_phone');
            $user_phone->setLabel('Phone Number');
            $this->addElement($user_phone);

            $user_country = new Zend_Form_Element_Text('user_country');
            $user_country->setLabel('Country');
            $this->addElement($user_country);

            $user_signature = new Zend_Form_Element_Textarea('user_signature');
            $user_signature->setLabel('Signature')->setAttrib('id','ck_replace');
            $this->addElement($user_signature);


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
		$this->addDisplayGroup($array, 'blogpost', array(
			'class'=>'fields user', 'legend' => 'User', 'id' => 'user'
		));
		$this->removeDecorator('DtDdWrapper');
		return $this;

     }
}

?>