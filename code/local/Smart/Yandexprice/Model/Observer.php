<?php

class Smart_Yandexprice_Model_Observer
{
    public function collectionLoadAfter($observer)
    {
        
        $collection = $observer->getEvent()->getCollection();

        $collection->addAttributeToSort('position', 'ASC');

        $observer->getEvent()->setCollection($collection);
    }
}