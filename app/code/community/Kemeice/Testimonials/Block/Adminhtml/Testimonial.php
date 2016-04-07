<?php

class Kemeice_Testimonials_Block_Adminhtml_Testimonial extends Mage_Adminhtml_Block_Widget_Grid_Container {

	public function __construct() {
		$this->_controller		= 'adminhtml_testimonial';
		$this->_blockGroup		= 'testimonials';
		$this->_headerText		= Mage::helper('testimonials')->__('Manage Testimonials');
		$this->_addButtonLabel	= Mage::helper('testimonials')->__('Add New Testimonial');
		parent::__construct();
	}
}