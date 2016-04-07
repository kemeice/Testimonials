<?php

class Kemeice_Testimonials_Block_Adminhtml_Testimonial_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {
		$form		= new Varien_Data_Form();
		$this->setForm($form);

		$fieldset	= $form->addFieldset('testimonial_form', array('legend' => Mage::helper('testimonials')->__('General Information')));

		$fieldset->addField('name', 'text', array(
			'label'		=> Mage::helper('testimonials')->__('Testimonial Name'),
			'class'		=> 'required-entry',
			'required'	=> true,
			'name'		=> 'name',
		));

		$statuses	= Mage::getSingleton('testimonials/status')->getOptionArray();
		array_unshift($statuses, array(
			'label'	=> '',
			'value'	=> '',
		));
		
		$fieldset->addField('status', 'select', array(
			'label'		=> Mage::helper('testimonials')->__('Status'),
			'name'		=> 'status',
			'values'	=> $statuses,
			'required'	=> true,
		));


		$fieldset->addField('description', 'editor', array(
			'name'		=> 'description',
			'label'		=> Mage::helper('testimonials')->__('Description'),
			'title'		=> Mage::helper('testimonials')->__('Description'),
			'style'		=> 'width: 98%; height: 200px;',
			'wysiwyg'	=> false,
			'required'	=> false,
		));

		if (Mage::getSingleton('adminhtml/session')->getTestimonialData()) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getTestimonialData());
			Mage::getSingleton('adminhtml/session')->setTestimonialData(null);
		} else if (Mage::registry('testimonial_data')) {
			$form->setValues(Mage::registry('testimonial_data')->getData());
		}

		return parent::_prepareForm();
	}
}