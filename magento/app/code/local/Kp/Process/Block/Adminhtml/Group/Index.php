<?php 
class Kp_Process_Block_Adminhtml_Group_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_controller = 'adminhtml_group_index';
		$this->_blockGroup = 'process';
		$this->_headerText = Mage::helper('process')->__('Process Group Grid');
		$this->_addButtonLabel = Mage::helper('process')->__('Add Process Group');
	}
}