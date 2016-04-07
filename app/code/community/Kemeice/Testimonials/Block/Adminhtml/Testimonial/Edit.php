<?php

class Kemeice_Testimonials_Block_Adminhtml_Testimonial_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

	public function __construct() {
		parent::__construct();

		$this->_objectId	= 'id';
		$this->_blockGroup	= 'testimonials';
		$this->_controller	= 'adminhtml_testimonial';

		//$this->_updateButton('save', 'label', Mage::helper('testimonials')->__('Save Testimonial'));
		//$this->_updateButton('delete', 'label', Mage::helper('testimonials')->__('Delete Testimonial'));

		$this->_addButton('save_and_continue', array(
			'label'		=> Mage::helper('testimonials')->__('Save and Continue Edit'),
			'onclick'	=> 'saveAndContinueEdit()',
			'class'		=> 'save',
		), -100);

		$this->_formScripts[] = "
			function saveAndContinueEdit() {
				editForm.submit($('edit_form').action + 'back/edit/');
			}
		";
	}

	public function getHeaderText() {
		if (Mage::registry('testimonial_data') && Mage::registry('testimonial_data')->getId()) {
			return Mage::helper('testimonials')->__("Edit Testimonial '%s'", $this->htmlEscape(Mage::registry('testimonial_data')->getName()));
		} else {
			return Mage::helper('testimonials')->__('Add New Testimonial');
		}
	}
}