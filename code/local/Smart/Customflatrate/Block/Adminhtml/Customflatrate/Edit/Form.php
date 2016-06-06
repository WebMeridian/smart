<?php
class Smart_Customflatrate_Block_Adminhtml_Customflatrate_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    

    
    protected function _prepareForm()
    {
        $id   = (int)$this->getRequest()->getParam('id');
        $form = new Varien_Data_Form(array(
                                        'id' => 'edit_form',
                                        'action' => $this->getUrl('*/*/save', array('id' => $id)),
                                        'method' => 'post',
                                     )
        );       
       

        $fieldset = $form->addFieldset('customflatrate_form', array('legend' => Mage::helper('customflatrate')->__('Customflatrate information')));
               
        if (Mage::getSingleton('adminhtml/session')->getCustomflatrateData()) {
            $data = Mage::getSingleton('adminhtml/session')->getCustomflatrateData();
            Mage::getSingleton('adminhtml/session')->getCustomflatrateData(null);
        } elseif (Mage::registry('customflatrate_data'))
            $data = Mage::registry('customflatrate_data')->getData();
        
        $fieldset->addField('active', 'select', array(
            'label' => Mage::helper('customflatrate')->__('Active'),
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('customflatrate')->__('No'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('customflatrate')->__('Yes'),
                ),
            ),
            'name' => 'active',
        ));
        
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('customflatrate')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));
        
        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('customflatrate')->__('Method Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));
        
       
        
        $fieldset->addField('type', 'select', array(
            'label' => Mage::helper('customflatrate')->__('Type'),
            'values' => array(
                array(
                    'value' => '',
                    'label' => Mage::helper('customflatrate')->__('No'),
                ),
                array(
                    'value' => 'O',
                    'label' => Mage::helper('customflatrate')->__('Per order'),
                ),
                array(
                    'value' => 'I',
                    'label' => Mage::helper('customflatrate')->__('Per item'),
                ),
            ),
            'name' => 'type',
        ));
        
        $fieldset->addField('price', 'text', array(
            'label' => Mage::helper('customflatrate')->__('Price'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'price',
        ));
        
        $fieldset->addField('handling_type', 'select', array(
            'label' => Mage::helper('customflatrate')->__('Calculate Handling Fee'),
            'values' => array(
                array(
                    'value' => 'F',
                    'label' => Mage::helper('customflatrate')->__('Fixed'),
                ),
                array(
                    'value' => 'P',
                    'label' => Mage::helper('customflatrate')->__('Percent'),
                ),
            ),
            'name' => 'handling_type',
        ));
        
        $fieldset->addField('handling_fee', 'text', array(
            'label' => Mage::helper('customflatrate')->__('Handling Fee'),
            'name' => 'handling_fee',
        ));
        
        $fieldset->addField('specificerrmsg', 'textarea', array(
            'label' => Mage::helper('customflatrate')->__('Displayed Error Message'),
            'name' => 'specificerrmsg',
        ));
        
        $fieldset->addField('infotext', 'textarea', array(
            'label' => Mage::helper('customflatrate')->__('Info text'),
            'name' => 'infotext',
        ));        

        $fieldset = $form->addFieldset('customflatrate_form2', 
                array(
                    'legend' => Mage::helper('customflatrate')->__('Country options'))
                );
               
        $fieldset->addField('sallowspecific', 'select', array(
            'label' => Mage::helper('customflatrate')->__('Allow for specific countries'),
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('customflatrate')->__('No'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('customflatrate')->__('Yes'),
                ),
            ),
            'name' => 'sallowspecific',
        ));
        
        $countryList = Mage::getModel('directory/country')->getResourceCollection()->toOptionArray(true);
        
        foreach($countryList as $key=>$country){
            if($key == 0){
                unset($countryList[$key]);
            }
        }
        
        $fieldset->addField('specificcountry', 'multiselect', array(
                    'name'      => 'specificcountry[]',
                    'label'     => Mage::helper('customflatrate')->__('Ship to Specific Countries'),
                    'title'     => Mage::helper('customflatrate')->__('Ship to Specific Countries'),
                    'values'    => $countryList,
                ));
        
        $fieldset->addField('sort', 'text', array(
            'label' => Mage::helper('customflatrate')->__('Sort order'),
            'name' => 'sort',
        ));
 
        $form->setValues($data);
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
    
     public function _prepareLayout()
    {

        return parent::_prepareLayout();
    }

}