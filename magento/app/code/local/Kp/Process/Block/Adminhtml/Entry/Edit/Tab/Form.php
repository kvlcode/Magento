<?php 
class Kp_Process_Block_Adminhtml_Entry_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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
    $model = Mage::registry('current_entry');
    $form = new Varien_Data_Form();

    $fieldset = $form->addFieldset('entry_form', array('legend'=>Mage::helper('process')->__('Entry Information')));


    $fieldset->addField('process_id', 'select', array(
      'label'     => $helper->__('Process Name'),          
      'name'      => 'process_id',
      'values' => $this->getProcessOptions(),
      ));


     $fieldset->addField('identifier', 'text', array(
        'label' => $helper->__('Identifier'),
        'required' => true,
        'name' => 'identifier'
        
        ));

       $fieldset->addField('data', 'text', array(
        'label' => $helper->__('Data'),
        'required' => true,
        'name' => 'data'
        
        ));
       
    $this->setForm($form);
    $form->setValues($model->getData());
    return parent::_prepareForm();

 }
}	