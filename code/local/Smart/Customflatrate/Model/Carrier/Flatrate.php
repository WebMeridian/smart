<?php

class Smart_Customflatrate_Model_Carrier_Flatrate extends Mage_Shipping_Model_Carrier_Flatrate
{
    
	public $_code = '';
        
	
	public function collectRates(Mage_Shipping_Model_Rate_Request $request)
	{
		if (!$this->getConfigFlag('active'))
		{
			return false;
		}
		
		$freeBoxes = 0;
		if ($request->getAllItems())
		{
			foreach ($request->getAllItems() as $item)
			{
			
				if ($item->getProduct()->isVirtual() || $item->getParentItem())
				{
					continue;
				}
				
				if ($item->getHasChildren() && $item->isShipSeparately())
				{
					foreach ($item->getChildren() as $child)
					{
						if ($child->getFreeShipping() && !$child->getProduct()->isVirtual())
						{
							$freeBoxes += $item->getQty() * $child->getQty();
						}
					}
				}
				elseif ($item->getFreeShipping())
				{
					$freeBoxes += $item->getQty();
				}
			}
		}
		$this->setFreeBoxes($freeBoxes);
		
		$result = Mage::getModel('shipping/rate_result');
		if ($this->getConfigData('type') == 'O')
		{
			$shippingPrice = $this->getConfigData('price');
		}
		elseif ($this->getConfigData('type') == 'I')
		{
			$shippingPrice = ($request->getPackageQty() * $this->getConfigData('price')) - ($this->getFreeBoxes() * $this->getConfigData('price'));
		}
		else
		{
			$shippingPrice = false;
		}
		
		$shippingPrice = $this->getFinalPriceWithHandlingFee($shippingPrice);
		
		if ($shippingPrice !== false)
		{
			$method = Mage::getModel('shipping/rate_result_method');
			
			$method->setCarrier($this->_code);
			$method->setCarrierTitle($this->getConfigData('title'));
			
			$method->setMethod($this->_code);
			$method->setMethodTitle($this->getConfigData('name'));
			
			if ($request->getFreeShipping() === true || $request->getPackageQty() == $this->getFreeBoxes())
			{
				$shippingPrice = '0.00';
			}

			
			$method->setPrice($shippingPrice);
			$method->setCost($shippingPrice);
			
			$result->append($method);
		}
		
		return $result;
	}
	
	public function getAllowedMethods()
	{
		return array($this->_code=>$this->getConfigData('name'));
	}
}
