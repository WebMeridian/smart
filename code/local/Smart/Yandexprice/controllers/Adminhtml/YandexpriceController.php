<?php
/**
 * @category   Smart
 * @package    Smart
 * @copyright  Copyright (c) 2012 Smart Web Development (http://www.peexl.com)
 * @license    http://framework.zend.com/license/new-bsd    New BSD License
 * @version    1.0.8
 */

class Smart_Yandexprice_Adminhtml_YandexpriceController extends Mage_Adminhtml_Controller_Action
{


    public function indexAction()
    {
        $this->_title($this->__('Yandex Price'));

        $this->loadLayout()
            ->_setActiveMenu('yandexprice/yandexprice')
            ->renderLayout();
    }

    public function generatepriceAction(){
        
        $filename = "price-".time().".csv";
        
        $products = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('status',array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED)); 

        $file = Mage::getBaseDir('export').'/'.$filename;
        $fp    = fopen($file, 'w');
        $list1 = array('id',
                       'type',
                       'available',
                       'bid',
                       'url',
                       'price',
                       'currencyId',
                       'category',
                       'picture',
                       'delivery',
                       'local_delivery_cost',
                       'typePrefix',
                       'vendor',
                       'model',
                       'description');

        fputs($fp, implode($list1, ';')."\n");

        $i = 0;

        foreach($products as $simple_product){

            $image = Mage::getModel('catalog/product_media_config')
                ->getMediaUrl($simple_product->getImage());

            $vendor        = '';
            $category_name = 'корм для животных';
            $categoryIds   = $simple_product->getCategoryIds();

            if(count($categoryIds) ){
                $firstCategoryId = $categoryIds[1];
                $_category       = Mage::getModel('catalog/category')->load($firstCategoryId);

                $category_name = $_category->getName();

                $lastCategoryId = $categoryIds[count($categoryIds)-1];
                $last_category  = Mage::getModel('catalog/category')->load($lastCategoryId);

                $vendor = $last_category->getName();
                $vendor = str_replace(array(";",'"',"!","\n","\r","\r\n","\n\r"),'',$vendor);
                $vendor = str_replace(array("'"),array("`"),$vendor);
            }

            $title = $simple_product->getName();
            $title = str_replace(array(";",'"',"!","\n","\r","\r\n","\n\r"),'',$title);
            $title = str_replace(array("'"),array("`"),$title);
            
            $desciption = strip_tags($simple_product->getDescription());
            $desciption = preg_replace("/&#?[a-z0-9]{2,8};/i","",$desciption);
            $desciption = str_replace(array(";",'"',"!","\n","\r","\r\n","\n\r"),'',$desciption);
            $desciption = str_replace(array("'"),array("`"),$desciption);

            $list3 = array($simple_product->getSku(),
                            'vendor.model',
                            'true',
                            '',
                            $simple_product->getProductUrl(),
                            $simple_product->getPrice(),
                            'RUR',
                            $category_name,
                            $image,
                            'true',
                             500,
                            '',
                            $vendor,
                            $title,
                            $desciption);

            fputs($fp, implode($list3, ';')."\n");

            //echo $simple_product->getSku() . " - " . $simple_product->getName() . " - " . Mage::helper('core')->currency($simple_product->getPrice()) . "<br>";
        }

        fclose($fp);
        
        $response = array("file"=>$filename,'url'=>Mage::helper("adminhtml")->getUrl('*/*/download',array('f'=>$filename)));
        
        echo json_encode($response);
    }

    public function downloadAction(){

        $dir  = Mage::getBaseDir('export');
        $file = $this->getRequest()->getParam('f');
        
        $this->_prepareDownloadResponse($file, array("type"=>'filename',"value"=>$dir.'/'.$file,"rm"=>0));
        
    }
    
    
    
    
}