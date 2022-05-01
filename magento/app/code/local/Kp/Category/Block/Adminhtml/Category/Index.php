<?php 
class Kp_Category_Block_Adminhtml_Category_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_controller = "adminhtml_category_index";
		$this->_blockGroup = "category";
		$this->_headerText = Mage::helper('category')->__('Category Grid');
		$this->_addButtonLabel = Mage::helper('category')->__('Add New');
	}
}