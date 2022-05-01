<?php 
class Kp_Process_Block_Adminhtml_Process_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_process_index';
		$this->_blockGroup = 'process';
		$this->_headerText = Mage::helper('process')->__('Process Grid');
		$this->_addButtonLabel = Mage::helper('process')->__('Add Process');
		parent::__construct();
	}
}