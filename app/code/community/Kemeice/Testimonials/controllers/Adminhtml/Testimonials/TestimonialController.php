<?php

class Kemeice_Testimonials_Adminhtml_Testimonials_TestimonialController extends Mage_Adminhtml_Controller_Action {

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('kemeice/testimonials/testimonial')
			->_addBreadcrumb(Mage::helper('testimonials')->__('Testimonial Manager'),
							Mage::helper('testimonials')->__('Testimonial Manager'));

		return $this;
	}

	protected function _setTitle() {
		return $this->_title($this->__('Testimonials'))->_title($this->__('Testimonial'));
	}

	public function indexAction() {
		$this->_setTitle();
		$this->_initAction();
		$this->renderLayout();
	}

	public function gridAction() {
		$this->getResponse()->setBody(
			$this->getLayout()->createBlock('testimonials/adminhtml_testimonial_grid')->toHtml()
		);
	}

	public function editAction() {
		$this->_setTitle();
		$testimonialId		= $this->getRequest()->getParam('id');
		$testimonialModel	= Mage::getModel('testimonials/testimonial')->load($testimonialId);

		if ($testimonialModel->getId() || $testimonialId == 0) {
			Mage::register('testimonial_data', $testimonialModel);
			$this->loadLayout();
			$this->_setActiveMenu('kemeice/testimonials/testimonial');
			$this->_addBreadcrumb(Mage::helper('testimonials')->__('Testimonial Manager'), Mage::helper('testimonials')->__('Testimonial Manager'));
			$this->_addBreadcrumb(Mage::helper('testimonials')->__('Testimonial Description'), Mage::helper('testimonials')->__('Testimonial Description'));
			
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_testimonial_edit'))
				->_addLeft($this->getLayout()->createBlock('testimonials/adminhtml_testimonial_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Testimonial does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($this->getRequest()->getPost()) {
			try {
				$postData			= $this->getRequest()->getPost();
				$testimonialModel	= Mage::getModel('testimonials/testimonial');
				if ($this->getRequest()->getParam('id') <= 0) {
					$testimonialModel->setCreatedTime(Mage::getSingleton('core/date')->gmtDate());
				}
				$testimonialModel->addData($postData)
								->setUpdateTime(Mage::getSingleton('core/date')->gmtDate())
								->setId($this->getRequest()->getParam('id'))
								->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('testimonials')->__('Testimonial was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setTestimonialData(false);

				// check if 'Save and Continue'
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $testimonialModel->getId()));
					return;
				}

				// go to grid
				$this->_redirect('*/*/');
				return;
				
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setTestimonialData($this->getRequest()->getPost());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

				return;
			}
		}

		$this->_redirect('*/*/');
	}

	public function deleteAction() {
		if ($this->getRequest()->getParam('id') > 0) {
			try {
				$testimonialModel	= Mage::getModel('testimonials/testimonial');
				$testimonialModel->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('testimonials')->__('Testimonial was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminihtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}

		$this->_redirect('*/*/');
	}

	public function massDeleteAction() {
		$ids	= $this->getRequest()->getParam('testimonial');
		if (!is_array($ids)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Please select Testimonial(s)'));
		} else {
			try {
				foreach ($ids as $id) {
					$testimonial = Mage::getModel('testimonials/testimonial')->load($id);
					$testimonial->delete();
				}

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('testimonials')->__('Total of %d Testimonial(s) were successfully deleted', count($ids)));

			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}

		$this->_redirect('*/*/');
	}

	public function massStatusAction() {
		$ids	= $this->getRequest()->getParam('testimonial');
		if (!is_array($ids)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Please select Testimonial(s)'));
		} else {
			try {
				foreach ($ids as $id) {
					$testimonial = Mage::getModel('testimonials/testimonial')
							->load($id)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save()
					;
				}

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('testimonials')->__('Total of %d Testimonial(s) were successfully updated', count($ids)));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}

		$this->_redirect('*/*/');
	}
}
