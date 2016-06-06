<?php
class Smart_Customflatrate_Model_Shipping_Shipping extends Mage_Shipping_Model_Shipping
{
    
    public function getCarrierByCode($carrierCode, $storeId = null)
    {
        if (!Mage::getStoreConfigFlag('carriers/'.$carrierCode.'/'.$this->_availabilityConfigField, $storeId)) {
            return false;
        }
        
        if(strpos($carrierCode,'customflatrate') !== false){
            
            $active_methods = array();
            $collection     = Mage::getModel('customflatrate/customflatrate')->getCollection()->addFieldToFilter('active',1);
            
            foreach($collection as $method){
                $active_methods[] = $method->getCode();
            }
            
            if(in_array($carrierCode,$active_methods)){
                $className = "customflatrate/carrier_flatrate";
            }
            else{
                return false;
            }            
        }        
        else{
            $className = Mage::getStoreConfig('carriers/'.$carrierCode.'/model', $storeId);
            if (!$className) {
                return false;
            }
        }
        
        //print $className;
        
        $obj = Mage::getModel($className);
        $obj->_code = $carrierCode;
        if ($storeId) {
            $obj->setStore($storeId);
        }
        return $obj;
    }

}
