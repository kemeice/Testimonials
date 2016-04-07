<?php


class Kemeice_Testimonials_Model_Testimonial extends Mage_Core_Model_Abstract {

	public function _construct() {
		parent::_construct();
		$this->_init('testimonials/testimonial');
	}

	public function getActiveTestimonialsOption() {
		$collection = Mage::getModel('testimonials/testimonial')
						->getCollection()
						->addFieldToFilter('status', array('eq' => '1'))
		;

		$options	= array();
		foreach ($collection as $testimonial) {
			$options[$testimonial->getTestimonialId()]	= $testimonial->getName();
		}

		return $options;
	}
}