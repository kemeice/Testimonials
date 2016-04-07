<?php

class Kemeice_Testimonials_Model_Mysql4_Testimonial_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

	public function _construct() {
		$this->_init('testimonials/testimonial');
	}
}