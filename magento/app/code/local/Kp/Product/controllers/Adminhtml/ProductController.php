<?php 
class Kp_Product_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->getLayout()->getBlock('content')->append(
			$this->getLayout()->createBlock('product/adminhtml_product_index'));
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
        $model = Mage::getModel('product/product');

        if ($id) 
        {
            $model->load($id);                   
            if(!$model->getId()) 
            {
                $this->_redirect('*/*/index');
                return;
            }
        }

        $this->_title($model->getId() ? $this->__('Edit Product') : $this->__('New Product'));
        Mage::register('current_product', $model);

        $this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('product/adminhtml_product_edit', 'productEdit'));
        $this->renderLayout();
    }  


     public function saveAction()
    {
    	// code...
    	if ($data = $this->getRequest()->getPost()) 
    	{
           try 
           {
               $model = Mage::getModel('product/product');
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
        $sampleIds = $this->getRequest()->getParam('product');
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
                    $sample = Mage::getModel('product/product')->load($sampleId);
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
        
        $this->_redirect('product/adminhtml_product/index');
    }
    
   public function deleteAction()
   {
       if($id = $this->getRequest()->getParam('id')) 
       {
           try 
           {
               Mage::getModel('product/product')->load($id)->delete();
           } 
           catch (Exception $e) 
           {
               $this->_redirect('*/*/edit', array('id' => $id));
           }
       }
       $this->_redirect('*/*/index');
   }
}