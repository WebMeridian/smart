<?php
class Smart_Customflatrate_Block_Adminhtml_Customflatrate_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        
        $this->_objectId = 'id';
        $this->_blockGroup = 'customflatrate';
        $this->_controller = 'adminhtml_customflatrate';
        $this->_updateButton('save', 'label', Mage::helper('customflatrate')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('customflatrate')->__('Delete'));        
                
        //$this->setId('customflatrate_customflatrate_edit');
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('customflatrate_data') && Mage::registry('customflatrate_data')->getId() ) {
            return Mage::helper('customflatrate')->__("Edit customflatrate '%s'", $this->htmlEscape(Mage::registry('customflatrate_data')->getTitle()));
        } else {
            return Mage::helper('customflatrate')->__('Add customflatrate');
        }
    }
    
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id')));
    }
  
  
    
}