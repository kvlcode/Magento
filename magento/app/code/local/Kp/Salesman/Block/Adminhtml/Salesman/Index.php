<?php 
class Kp_Salesman_Block_Adminhtml_Salesman_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_controller = "adminhtml_salesman_index";
		$this->_blockGroup = "salesman";
		$this->_headerText = Mage::helper('salesman')->__('Salesman Grid');
		$this->_addButtonLabel = Mage::helper('salesman')->__('Add New');
	}
}