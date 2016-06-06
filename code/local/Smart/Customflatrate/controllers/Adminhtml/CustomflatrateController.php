<?php
 class Smart_Customflatrate_Adminhtml_CustomflatrateController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customflatrate/customflatrate')     
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Customflate Manager'), Mage::helper('adminhtml')->__('Customflate Manager'));
        $id = (int)$this->getRequest()->getParam('id',0);
        if($id != 0){
            $model = Mage::getModel('customflatrate/customflatrate')->load($id);
            if ($model->getId() || $id == 0) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if (!empty($data)) {
                    $model->setData($data);
                }
            }
            Mage::register('customflatrate_data', $model);
        }
        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
        $this->renderLayout();
    }
 
    public function editAction()
    {
        $id    = (int)$this->getRequest()->getParam('id');
        $model = Mage::getModel('customflatrate/customflatrate')->load($id);
                    
        if($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
                $model->setData($data);
            
            Mage::register('customflatrate_data', $model);
            
            $this->loadLayout();
            $this->_setActiveMenu('customflatrate/customflatrate');
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('customflatrate/adminhtml_customflatrate_edit'));            
            $this->renderLayout();
        }    
        else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cafe')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
   
    public function newAction()
    {
        $this->_forward('edit');
    }
   
    public function saveAction()
    {
        if ($this->getRequest()->getPost()) {
                        
            try {
                $id         = $this->getRequest()->getParam('id',0);
                $postData   = $this->getRequest()->getPost();
                
                if($id == 0)
                {
                   $model = Mage::getModel('customflatrate/customflatrate');                 
                }    
                else{
                   $model = Mage::getModel('customflatrate/customflatrate')->load($id);  
                }
                
                $last_item = Mage::getModel('customflatrate/customflatrate')->getCollection()->getLastItem();
                
                if($model->getId())
                {
                    $code = $model->getCode();
                }
                else{
                    if($last_item->getId()){
                        $new_id = $last_item->getId()+1;
                        $code   = "customflatrate".$new_id;
                    }
                    else{
                        $code = "customflatrate1";
                    }
                }
                
                $postData['specificcountry'] = implode(',', $postData['specificcountry']);
                
                $model->setActive($postData['active'])
                        ->setTitle($postData['title'])
                        ->setName($postData['name'])
                        ->setType($postData['type'])
                        ->setCode($code)
                        ->setPrice($postData['price'])
                        ->setHandlingType($postData['handling_type'])
                        ->setHandlingFee($postData['handling_fee'])
                        ->setSpecificerrmsg($postData['specificerrmsg'])
                        ->setSallowspecific($postData['sallowspecific'])
                        ->setSpecificcountry($postData['specificcountry'])
                        ->setShowmethod($postData['showmethod'])                        
                        ->setSortOrder($postData['sort_order'])
                        ->setInfotext($postData['infotext'])   
                        ->save();
                
                //save config
                Mage::getConfig()->saveConfig("carriers/$code/active", $model->getActive(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/title", $model->getTitle(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/name", $model->getName(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/type", $model->getType(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/price", $model->getPrice(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/handling_type", $model->getHandlingType(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/handling_fee", $model->getHandlingFee(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/specificerrmsg", $model->getSpecificerrmsg(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/sallowspecific", $model->getSallowspecific(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/specificcountry", $model->getSpecificcountry(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/showmethod", $model->getShowmethod(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/sort_order", $model->getSortOrder(), 'default', 0);
                Mage::getConfig()->saveConfig("carriers/$code/infotext", $model->getInfotext(), 'default', 0);
                //////////////////
                
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setModelData(false);
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setmodelData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        
        $this->_redirect('*/*/');
    }
   
    public function deleteAction()
    {
        $id    = (int)$this->getRequest()->getParam('id');
        $model = Mage::getModel('customflatrate/customflatrate')->load($id); 
        
        if($model->getId()) {
            
            try {                                
                $code = $model->getCode();
                
                Mage::getConfig()->deleteConfig("carriers/$code/active", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/title", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/name", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/type", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/price", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/handling_type", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/handling_fee", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/specificerrmsg", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/sallowspecific", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/specificcountry", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/showmethod", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/sort_order", 'default', 0);
                Mage::getConfig()->deleteConfig("carriers/$code/infotext", 'default', 0);
                                
                $model->setId($id)
                    ->delete();
  
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
        $this->_redirect('*/*/');
    }
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('customflatrate/adminhtml_customflatrate_grid')->toHtml()
        );
    }
}