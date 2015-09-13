<?php

/**
 * @category   Netalico
 * @package    Netalico_AdminOrderItem
 * @author     Chris Jones <leeked@gmail.com>
 */
class Netalico_AdminOrderItem_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ALLOW_OUT_OF_STOCK = 'cataloginventory/adminorderitem/allow_out_of_stock';
    const XML_PATH_ALLOW_DISABLED     = 'cataloginventory/adminorderitem/allow_disabled';

    /**
     * @return bool
     */
    public function allowOutOfStock()
    {
        return (bool) Mage::getStoreConfig(self::XML_PATH_ALLOW_OUT_OF_STOCK);
    }

    /**
     * @return bool
     */
    public function allowDisabled()
    {
        return (bool) Mage::getStoreConfig(self::XML_PATH_ALLOW_DISABLED);
    }

    /**
     * @return bool
     */
    public function isInvalid($row)
    {
        if (! $this->allowDisabled()) {
            // If Product is Disabled
            if ($row->getStatus() == Mage_Catalog_Model_Product_Status::STATUS_DISABLED) {
                return true;
            }
        }

        if (! $this->allowOutOfStock()) {
            // If Out of Stock
            if (! $row->getIsSaleable()) {
                return true;
            }
        }
    }
}
