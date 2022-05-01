<?php
class Kp_Process_Block_Adminhtml_Column_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  { 
 
    parent::__construct();
    $this->setId('ProcessColumnGrid');
    $this->setDefaultSort('column_id');
    $this->setUseAjax(true);
    $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
    $collection = Mage::getModel('process/process_column')->getCollection();
    $this->setCollection($collection);
    return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
    $this->addColumn('column_id', array(
      'header'    => Mage::helper('process')->__('Column Id'),
      'index'     => 'column_id',
    )); 
     $this->addColumn('process_id', array(
      'header'    => Mage::helper('process')->__('Process Id'),
      'index'     => 'process_id',
    ));   

    $this->addColumn('name', array(
      'header'    => Mage::helper('process')->__('Name'),
      'index'     => 'name',
    ));

    $this->addColumn('sample_value', array(
      'header'    => Mage::helper('process')->__('Sample Value'),
      'index'     => 'sample_value',
    ));

    $this->addColumn('required', array(
        'header' => Mage::helper('process')->__('Required'),
        'index' => 'required',
        'type'      => 'options',
              'options'   => array(
                  Kp_Process_Model_Process_Column::REQUIRED_YES => Mage::helper('process')->__('Yes'),
                  Kp_Process_Model_Process_Column::REQUIRED_NO => Mage::helper('process')->__('No')  
              ),
    ));

    $this->addColumn('casting_type', array(
        'header' => Mage::helper('process')->__('Casting Type'),
        'index' => 'casting_type',
        'type'      => 'options',
              'options'   => array(
                  Kp_Process_Model_Process_Column::CASTING_TYPE_INT => Mage::helper('process')->__('Int'),
                  Kp_Process_Model_Process_Column::CASTING_TYPE_VARCHAR => Mage::helper('process')->__('Varchar'),
                  Kp_Process_Model_Process_Column::CASTING_TYPE_DECIMAL => Mage::helper('process')->__('Decimal')
              ),
    ));

    $this->addColumn('exception', array(
      'header'    => Mage::helper('process')->__('Exception'),
      'index'     => 'exception',
      'type'      => 'options',
              'options'   => array(
                Kp_Process_Model_Process_Column::EXCEPTION_YES => Mage::helper('process')->__('Yes'),
                Kp_Process_Model_Process_Column:: EXCEPTION_NO=> Mage::helper('process')->__('No'),    
              ),
    ));

     $this->addColumn('created_date', array(
      'header'    => Mage::helper('process')->__('Created Date'),
      'index'     => 'created_date',
    ));

    return parent::_prepareColumns();
  }   

  protected function _prepareMassaction()
  {
    $this->setMassactionIdField('process_column_id');
    $this->getMassactionBlock()->setFormFieldName('process');

    $this->getMassactionBlock()->addItem('delete', array(
     'label'    => Mage::helper('process')->__('Delete'),
     'url'      => $this->getUrl('*/*/massDelete'),
     'confirm'  => Mage::helper('process')->__('Are you sure?')
   ));
  }

  public function getRowUrl($row)
  {
    return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }  
}