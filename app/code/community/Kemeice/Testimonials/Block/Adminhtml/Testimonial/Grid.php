<?php

class Kemeice_Testimonials_Block_Adminhtml_Testimonial_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	public function __construct() {
		parent::__construct();
		$this->setId('testimonialGrid');
		$this->setDefaultSort('testimonial_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}

	protected function _prepareCollection() {
		$collection	= Mage::getModel('testimonials/testimonial')->getCollection();
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns() {
		$this->addColumn('testimonial_id', array(
			'header'	=> Mage::helper('testimonials')->__('ID'),
			'align'		=> 'right',
			'width'		=> '50px',
			'index'		=> 'testimonial_id',
			'type'		=> 'number',
		));

		$this->addColumn('name', array(
			'header'	=> Mage::helper('testimonials')->__('Name'),
			'align'		=> 'left',
			'index'		=> 'name',
		));
		$statuses	= Mage::getSingleton('testimonials/status')->getOptionArray();
		$this->addColumn('status', array(
			'header'	=> Mage::helper('testimonials')->__('Status'),
			'align'		=> 'left',
			'width'		=> '80px',
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> $statuses,
		));


		$this->addColumn('action', array(
			'header'	=> Mage::helper('testimonials')->__('Action'),
			'width'		=> '100px',
			'type'		=> 'action',
			'getter'	=> 'getId',
			'actions'	=> array(
				array(
					'caption'	=> Mage::helper('testimonials')->__('Edit'),
					'url'		=> array('base' => '*/*/edit'),
					'field'		=> 'id',
				),
			),
			'filter'	=> false,
			'sortable'	=> false,
			'index'		=> 'stores',
			'is_system'	=> true,
		));

		return parent::_prepareColumns();
	}

	protected function _prepareMassaction() {
		$this->setMassactionIdField('testimonial_id');
		$this->getMassactionBlock()->setFormFieldName('testimonial');
		$this->getMassactionBlock()->addItem('delete', array(
			'label'		=> Mage::helper('testimonials')->__('Delete'),
			'url'		=> $this->getUrl('*/*/massDelete'),
			'confirm'	=> Mage::helper('testimonials')->__('Are you sure?'),
		));

		$statuses	= Mage::getSingleton('testimonials/status')->getOptionArray();
		array_unshift($statuses, array(
			'label'	=> '',
			'value'	=> '',
		));

		$this->getMassactionBlock()->addItem('status', array(
			'label'			=> Mage::helper('testimonials')->__('Change status'),
			'url'			=> $this->getUrl('*/*/massStatus', array('_current' => true)),
			'additional'	=> array(
				'visibility'	=> array(
					'name'			=> 'status',
					'type'			=> 'select',
					'class'			=> 'required-entry',
					'label'			=> Mage::helper('testimonials')->__('Status'),
					'values'		=> $statuses,
				),
			),
		));

		return $this;
	}

	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}

	public function getGridUrl() {
		return $this->getUrl('*/*/grid', array('_current' => true));
	}
}