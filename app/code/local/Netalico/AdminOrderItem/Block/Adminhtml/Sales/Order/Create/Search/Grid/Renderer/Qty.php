<?php

/**
 * @category   Netalico
 * @package    Netalico_AdminOrderItem
 * @author     Chris Jones <leeked@gmail.com>
 */
class Netalico_AdminOrderItem_Block_Adminhtml_Sales_Order_Create_Search_Grid_Renderer_Qty extends Mage_Adminhtml_Block_Sales_Order_Create_Search_Grid_Renderer_Qty
{
	/**
     * @param   Varien_Object $row
     * @return  bool
     */
    protected function _isInactive($row)
    {
        // If Grouped Product
        if (parent::_isInactive($row)) {
            return true;
        }

        return Mage::helper('netalico_adminorderitem')->isInvalid($row);
    }

	/**
	 * @param   Varien_Object $row
	 * @return  string
	 */
	public function render(Varien_Object $row)
	{
		$html = parent::render($row);

		if (Mage::helper('netalico_adminorderitem')->isInvalid($row)) {
			$html = str_replace('<input type="text"', '<input type="hidden"', $html);
		}

		return $html;
	}
}
