<?php 
class Kp_Process_Block_Adminhtml_Column_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_controller = 'adminhtml_column_index';
		$this->_blockGroup = 'process';
		$this->_headerText = Mage::helper('process')->__('Process Column Grid');
		$this->_addButtonLabel = Mage::helper('process')->__('Add Process Column');
	}
}