<?php

/**
 * @category   Netalico
 * @package    Netalico_AdminOrderItem
 * @author     Chris Jones <leeked@gmail.com>
 */
class Netalico_AdminOrderItem_Model_CatalogInventory_Observer extends Mage_CatalogInventory_Model_Observer
{
    /**
     * Check product inventory data when quote item quantity declaring
     *
     * @param  Varien_Event_Observer $observer
     * @return Mage_CatalogInventory_Model_Observer
     */
    public function checkQuoteItemQty($observer)
    {
        $observer->getEvent()->getItem()->getQuote()->setIsSuperMode(false);

        return parent::checkQuoteItemQty($observer);
    }
}
