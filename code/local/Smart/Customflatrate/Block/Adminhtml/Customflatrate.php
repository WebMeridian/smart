<?php
class Smart_Customflatrate_Block_Adminhtml_Customflatrate extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_customflatrate';
        $this->_blockGroup = 'customflatrate';
        $this->_headerText = Mage::helper('customflatrate')->__('Custom flatrate Manager');

        parent::__construct();
    }
    

}