<?php

class Kemeice_Testimonials_Block_Testimonials extends Mage_Core_Block_Template {

	public function _prepareLayout() {
		return parent::_prepareLayout();
	}

	public function getTestimonials() {
		return Mage::getModel('testimonials/testimonial')
						->getCollection()
						->addFieldToFilter('status', array('eq' => '1'))
		;
	}
}