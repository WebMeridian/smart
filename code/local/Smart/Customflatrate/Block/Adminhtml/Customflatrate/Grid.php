<?php
class Smart_Customflatrate_Block_Adminhtml_Customflatrate_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('customflatrateGrid');
        // This is the primary key of the database
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        //$store = $this->_getStore();
        $collection = Mage::getModel('customflatrate/customflatrate')->getCollection();
//        if ($this->_getStoreId()){
//            $collection->addStoreFilter($this->_getStoreId());
//        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _prepareMassaction() {
        return $this;
    }

    private function _getStoreId() {
        return (int) $this->getRequest()->getParam('store', 0);
    }

    protected function _getStore() {
        return Mage::app()->getStore($this->_getStoreId());
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('customflatrate')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'id',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('customflatrate')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));


        $this->addColumn('code', array(
            'header'    => Mage::helper('customflatrate')->__('Code'),
            'align'     =>'left',
            'index'     => 'code',
        ));
        
        $this->addColumn('price', array(
            'header'    => Mage::helper('customflatrate')->__('Price'),
            'align'     =>'left',
            'index'     => 'price',
        ));
        
        
        $this->addColumn('active', array(
            'header'    => Mage::helper('customflatrate')->__('Active'),
            'align'     =>'left',
            'index'     => 'active',
        ));
                
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }


}