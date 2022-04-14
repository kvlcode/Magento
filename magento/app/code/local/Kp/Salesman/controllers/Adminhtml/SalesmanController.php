<?php 
class Kp_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('salesman/adminhtml_salesman_index'));
		$this->renderLayout();
	}

	public function newAction()
   	{
        $this->_forward('edit');
   	}

	public function editAction()
    {
       $this->loadLayout();

        $id =  $this->getRequest()->getParam('id');   
        $model = Mage::getModel('salesman/salesman');

        if ($id) 
        {
            $model->load($id);                   
            if(!$model->getId()) 
            {
                $this->_redirect('*/*/index');
                return;
            }
        }

        $this->_title($model->getId() ? $this->__('Edit Salesman') : $this->__('New Salesman'));
        Mage::register('current_salesman', $model);

        $this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('salesman/adminhtml_salesman_edit', 'salesmanEdit'));
        $this->renderLayout();
    }  


     public function saveAction()
    {
    	// code...
    	if ($data = $this->getRequest()->getPost()) 
    	{
           try 
           {
               $model = Mage::getModel('salesman/salesman');
               $model->setData($data)->setId($this->getRequest()->getParam('id'));
               $model->save();
               $id = $model->getId();
               $this->_redirect('*/*/index');
           } 
           catch (Exception $e) 
           {
               $this->_redirect('*/*/edit', array(
                   'id' => $this->getRequest()->getParam('id')
               ));
           }
           return;
        }
    }


    public function massDeleteAction() 
    {
        $sampleIds = $this->getRequest()->getParam('salesman');
         if(!is_array($sampleIds))
        {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } 
        else 
        {
            try
            {
                foreach ($sampleIds as $sampleId)
                {
                    $sample = Mage::getModel('salesman/salesman')->load($sampleId);
                    $sample->delete();

                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($sampleIds)));
            } 
            catch (Exception $e)
            {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        
        $this->_redirect('salesman/adminhtml_salesman/index');
    }
    
   public function deleteAction()
   {
       if($id = $this->getRequest()->getParam('id')) 
       {
           try 
           {
               Mage::getModel('salesman/salesman')->load($id)->delete();
           } 
           catch (Exception $e) 
           {
               $this->_redirect('*/*/edit', array('id' => $id));
           }
       }
       $this->_redirect('*/*/index');
   }
}