<?php 

class Kp_Process_Block_Adminhtml_Column_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function getProcessOptions()
    {
      $model = Mage::getModel('process/process');
      $select = $model->getCollection()
                  ->getSelect()
                  ->reset(Zend_Db_Select::COLUMNS)
                  ->columns(['value' => 'process_id','label' => 'name'])
                  ->order('name','ASC');
        $processOptions = $model->getResource()->getReadConnection()->fetchAll($select);        
        if ($processOptions) 
        {
          return $processOptions;
        }
        return [];
    }

	protected function 	_prepareForm()
	{
		$helper = Mage::helper('process');
	    $model = Mage::registry('current_column');
	    $form = new Varien_Data_Form();

	    $fieldset = $form->addFieldset('Column_form', array('legend'=>Mage::helper('process')->__('Column information')));

        $fieldset->addField('process_id', 'select', array(
          'label'     => $helper->__('Process Name'),          
          'name'      => 'process_id',
          'values' => $this->getProcessOptions(),
        ));

       $fieldset->addField('name', 'text', array(
        'label' => $helper->__('Name'),
        'required' => true,
        'name' => 'name'
        
        ));

       $fieldset->addField('sample_value', 'text', array(
        'label' => $helper->__('Sample Value'),
        'required' => true,
        'name' => 'sample_value'
        
        ));

       $fieldset->addField('required', 'select', array(
            'label' => $helper->__('Required'),
            'required' => true,
            'name' => 'required',
            'values' => [
                    ['value' => Kp_Process_Model_Process_Column::REQUIRED_YES, 'label' =>Mage::helper('process')->__('YES')],
                    ['value' => Kp_Process_Model_Process_Column::REQUIRED_NO, 'label' =>Mage::helper('process')->__('NO')],
            ]
        ));


         $fieldset->addField('casting_type', 'select', array(
            'label' => $helper->__('Casting Type'),
            'required' => true,
            'name' => 'casting_type',
            'values' => [
                    ['value' => Kp_Process_Model_Process_Column::CASTING_TYPE_VARCHAR, 'label' => Mage::helper('process')->__('VARCHAR')],
                    ['value' => Kp_Process_Model_Process_Column::CASTING_TYPE_INT, 'label' => Mage::helper('process')->__('INT')],
                    ['value' => Kp_Process_Model_Process_Column::CASTING_TYPE_DECIMAL, 'label' => Mage::helper('process')->__('DECIMAL')],
            ]
        ));
         $fieldset->addField('exception', 'select', array(
            'label' => $helper->__('Exception'),
            'required' => true,
            'name' => 'exception',
            'values' => [
                    ['value' => Kp_Process_Model_Process_Column::EXCEPTION_YES, 'label' => Mage::helper('process')->__('YES')],
                    ['value' => Kp_Process_Model_Process_Column::EXCEPTION_NO, 'label' => Mage::helper('process')->__('NO')],
            ]
        ));

	    $this->setForm($form);
	    $form->setValues($model->getData());
	    return parent::_prepareForm();

 }
}	