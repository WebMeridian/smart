<?php


class Smart_Customflatrate_Model_Shipping_Config extends Mage_Shipping_Model_Config
{

    public function getCarrierInstance($carrierCode, $store = null)
    {
        $carrierConfig =  Mage::getStoreConfig('carriers/'.$carrierCode, $store);
               
        if(strpos($carrierCode,'customflatrate') !== false){
            
            $active_methods = array();
            $collection     = Mage::getModel('customflatrate/customflatrate')->getCollection()->addFieldToFilter('active',1);
            
            foreach($collection as $method){
                $active_methods[] = $method->getCode();
            }
            
            if(in_array($carrierCode,$active_methods)){
                $carrierConfig = array('model'=>'customflatrate/carrier_flatrate');
            }
        } 

        if (!empty($carrierConfig)) {
            return $this->_getCarrier($carrierCode, $carrierConfig, $store);
        }
        return false;
    }
    
    protected function _getCarrier($code, $config, $store = null)
    {
        if (!isset($config['model'])) {
            return false;
        }
        $modelName = $config['model'];
        
        /**
         * Added protection from not existing models usage.
         * Related with module uninstall process
         */
        try {
            $carrier        = Mage::getModel($modelName);
            $carrier->_code = $code;
        } catch (Exception $e) {
            Mage::logException($e);
            return false;
        }
        $carrier->setId($code)->setStore($store);
        self::$_carriers[$code] = $carrier;
        return self::$_carriers[$code];
    }
}
