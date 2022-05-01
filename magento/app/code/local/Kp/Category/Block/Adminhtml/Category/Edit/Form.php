<?php
class Kp_Category_Block_Adminhtml_Category_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('current_category');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id')
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $this->setForm($form);

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('category')->__('General Information')));

        $fieldset->addField('parent_id', 'select', array(
            'name'      => 'parent_id',
            'label'     => Mage::helper('category')->__('Select Parent'),
            'values'     => $this->selectDropdown(),
        ));

        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('category')->__('Name'),
            'required'  => true
        ));

        $fieldset->addField('sataus', 'select', array(
            'name'      => 'sataus',
            'label'     => Mage::helper('category')->__('Status'),
            'required'  => true,
            'type'      => 'options',
            'options'   => array(
                            1 => 'Enable',
                            2 => 'Disable'
                        ),
        ));


        $form->setValues($model->getData());
        $form->setUseContainer(true);
        return parent::_prepareForm();
    }

    protected function selectDropdown()
    {
        $id = $this->getRequest()->getParam('id');
        $categoryModel = Mage::getModel('category/category');
        $categoryValues = $categoryModel->getCollection()->getItems();
        $finalarray = [];
        $finalarray['root'] = array('value'=>null ,'label'=>'Root Category');

        if($id)
        {

            $allPath = $categoryModel->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` WHERE `path` NOT LIKE '%$id%' ");
        }
        else
        {

            $allPath = $categoryModel->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` ORDER BY `path`");
        }

        foreach ($categoryValues as $category) 
        {
           foreach ($allPath as $data)
            {
                if($category['category_id'] == $data['category_id'])
                {
                    $category_id = $category['category_id'];
                    $path = $category->getPath();
                    $dropDownValues = array('value'=>$category_id ,'label'=>$path);
                    $finalarray[$category_id] = $dropDownValues;
                }
            }       
        }

        return $finalarray;
    }
}


