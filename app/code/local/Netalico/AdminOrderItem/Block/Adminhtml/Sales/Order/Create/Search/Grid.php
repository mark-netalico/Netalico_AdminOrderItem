<?php

/**
 * @category   Netalico
 * @package    Netalico_AdminOrderItem
 * @author     Chris Jones <leeked@gmail.com>
 */
class Netalico_AdminOrderItem_Block_Adminhtml_Sales_Order_Create_Search_Grid extends Mage_Adminhtml_Block_Sales_Order_Create_Search_Grid
{
	/**
	 * @param Varien_Data_Collection $collection
	 */
	public function setCollection($collection)
	{
		if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
            Mage::getModel('cataloginventory/stock_item')->addCatalogInventoryToProductCollection($collection);
        }

		$this->_collection = $collection;
	}

	/**
     * Prepare columns
     *
     * @return Mage_Adminhtml_Block_Sales_Order_Create_Search_Grid
     */
    protected function _prepareColumns()
    {
		parent::_prepareColumns();

        $this->addColumnAfter('status',
            array(
                'header'         => Mage::helper('catalog')->__('Status'),
                'width'          => '70px',
                'index'          => 'status',
                'type'           => 'options',
                'options'        => Mage::getSingleton('catalog/product_status')->getOptionArray(),
                'frame_callback' => array($this, 'decorateStatus'),
        ), 'price');

		if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
			$this->addColumnAfter('is_saleable', array(
				'header'         => Mage::helper('catalog')->__('Inventory'),
				'width'          => '130px',
				'renderer'       => 'adminhtml/catalog_product_edit_tab_super_config_grid_renderer_inventory',
				'filter'         => 'adminhtml/catalog_product_edit_tab_super_config_grid_filter_inventory',
				'index'          => 'is_saleable',
				'frame_callback' => array($this, 'decorateInventory'),
			), 'price');
		}

		$this->getColumn('in_products')->setData('renderer', 'netalico_adminorderitem/adminhtml_sales_order_create_search_grid_renderer_checkbox');

		return Mage_Adminhtml_Block_Widget_Grid::_prepareColumns();
	}

	/**
     * @return string
     */
    public function decorateInventory($value, $row, $column, $isExport)
    {
		$cell = '<span><span>'.$value.'</span></span>';

		if (! Mage::helper('netalico_adminorderitem')->allowOutOfStock()) {
			// If Out of Stock
			if (! $row->getIsSaleable()) {
				$cell = str_replace('<span><span>', '<span style="color: #D40707"><span>', $cell);
			}
		}

        return $cell;
    }

    /**
     * @return string
     */
    public function decorateStatus($value, $row, $column, $isExport)
    {
		$cell = '<span><span>'.$value.'</span></span>';

		if (! Mage::helper('netalico_adminorderitem')->allowDisabled()) {
            // If Product is Disabled
            if ($row->getStatus() == Mage_Catalog_Model_Product_Status::STATUS_DISABLED) {
                $cell = str_replace('<span><span>', '<span style="color: #D40707"><span>', $cell);
            }
        }

		return $cell;
    }

    /**
     * @param Mage_Catalog_Model_Product|Varien_Object
     * @return string
     */
    public function getRowUrl($row)
    {
        return Mage::helper('netalico_adminorderitem')->isInvalid($row) ? null : parent::getRowUrl($row);
    }

	/**
	 * @return string
	 */
    public function getRowClass($row)
    {
        return Mage::helper('netalico_adminorderitem')->isInvalid($row) ? 'invalid' : parent::getRowClass($row);
    }
}
