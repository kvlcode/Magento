<?php
class Kp_Category_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function _construct()
    {
        $this->_blockGroup = 'category';
        $this->_controller = 'adminhtml_category';
    }

    public function getHeaderText()
    {
        if (Mage::registry('current_category')->getId()) 
        {
            return Mage::helper('category')->__("Edit Category");
        }
        else 
        {
            return Mage::helper('category')->__('New Category');
        }
    }

}

