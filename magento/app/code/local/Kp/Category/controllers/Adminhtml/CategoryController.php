<?php 
class Kp_Category_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->getLayout()->getBlock('content')->append(
			$this->getLayout()->createBlock('category/adminhtml_category_index'));
		$this->renderLayout();
	}

	public function newAction()
	{		
		$this->_forward('edit');
	}

	public function editAction()
	{
		$this->loadLayout();
		$id = $this->getRequest()->getParam('id');
		$model = MAGE::getModel('category/category');

		if ($id) 
		{
			$model->load($id);
			if(!$model->getId())
			{
				$this->redirect('*/*/index');
				return;
			}
		}

		$this->_title($model->getId() ? $this->__('Edit Category') : $this->__('New Category'));
		Mage::register('current_category', $model);

		$this->getLayout()->getBlock('content')->append(
			$this->getLayout()->createBlock('category/adminhtml_category_edit','categoryEdit'));
        $this->renderLayout();	
	}


	public function saveAction()
	{
		$formData = $this->getRequest()->getPost();
		unset($formData['form_key']);
		$name = $this->getRequest()->getPost('name');
		$id = $this->getRequest()->getParam('id');
		$categoryModel = Mage::getModel('category/category');
		$setData = $categoryModel->setData($formData);

		if(!$id)
		{
			// echo "<pre>";
			$setData->created_at = date("Y-m-d H:m:s");
			$insert = $categoryModel->save();
			$insertId= $insert['category_id'];
			$categoryPath = $categoryModel->load($formData['parent_id']);
			// print_r($categoryPath->parent_id);
			$newPath = NULL;
			if($categoryPath->parent_id)
			{
				$newPath = $categoryPath->path.'/'.$insertId;
			}
			else
			{
				$newPath = $insertId;
			}
			
		
			$updatePath = $categoryModel->load($insertId);
			$updatePath->parent_id = $insertId;
			$updatePath->path = $newPath;
			$updatePath->save();
		}
		else
		{
			if(!empty($id))
            {
                $setData->category_id = $id;
                $setData->updated_at = date('Y-m-d h:m:s');
                if(!$formData['parent_id'])
                {
                    $setData->parent_id = NULL;
                }
                else
                {
                	$setData->parent_id = $formData['parent_id'];	
                }
                unset($setData['parent_id']);
            
                $result = $categoryModel->save();
                if(!$result)
                {
                    throw new Exception("Sysetm is unable to save your data");   
                }

                $allPath = $categoryModel->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` WHERE `path` LIKE '%$id%' ");
                 
                foreach ($allPath as $path) 
                {
                    $finalPath = explode('/',$path['path']);
                    foreach ($finalPath as $subPath) 
                    {
                        if($subPath == $id)
                        {
                            if(count($finalPath) != 1)
                            {
                                array_shift($finalPath);
                            }    
                            break;
                        }
                        array_shift($finalPath);
                    }
                    if($path['parent_id'])
                    {
                        $parentPath = $categoryModel->load($path['parent_id']);
                        $path['path'] = $parentPath->path ."/".implode('/',$finalPath);
                    }
                    else
                    {
                        $path['path'] = $path['category_id'];
                    }
                    $savePath = Mage::getModel('category/category');
                    $savePath->setData($path);
                    $result = $savePath->save();
                }
            }
		}
		$this->_redirect('*/*/index');
	}


	public function massDeleteAction() 
    {
        $sampleIds = $this->getRequest()->getParam('category');
        $categoryModel = Mage::getModel('category/category');
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
                    $sample = Mage::getModel('category/category')->load($sampleId);
                    $id = $categoryModel->getResource()->getReadConnection()->fetchAll("SELECT `path` FROM `category` WHERE `path` LIKE '%$sampleId%' ");

                    foreach ($id as $key => $value) 
                    {
                    	$idArray = explode('/', $value['path']);
                    	$category_id = array_pop($idArray);
        	            $sample->delete()->where('category_id = ?', $category_id);
                    }

                }
                exit;
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($sampleIds)));
            } 
            catch (Exception $e)
            {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        
        $this->_redirect('category/adminhtml_category/index');
    }


 	public function deleteAction()
    {
        $categoryModel = Mage::getModel('category/category');
        $id = (int)$this->getRequest()->getParam('id');
        $allPath = $categoryModel->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` WHERE `path` LIKE '%$id%' ");
        
        foreach($allPath as $categories)
        {
            $delete = $categoryModel->setId($categories['category_id'])->delete();
        }
        $this->_redirect('*/*/');
    }

}