<?php

/**
 * @category   Netalico
 * @package    Netalico_AdminOrderItem
 * @author     Chris Jones <leeked@gmail.com>
 */
class Netalico_AdminOrderItem_Block_Adminhtml_Sales_Order_Create_Search_Grid_Renderer_Checkbox extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Checkbox
{
    /**
     * @param   Varien_Object $row
     * @return  bool
     */
    protected function _isInactive($row)
    {
        return Mage::helper('netalico_adminorderitem')->isInvalid($row);
    }

    /**
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        if ($this->_isInactive($row)) {
            $disabledValues   = (array) $this->getColumn()->getDisabledValues();
            $disabledValues[] = $row->getData($this->getColumn()->getIndex());

            $this->getColumn()->setDisabledValues($disabledValues);
        }

        return parent::render($row);
    }

    /**
     * @param string $value   Value of the element
     * @param bool   $checked Whether it is checked
     * @return string
     */
    protected function _getCheckboxHtml($value, $checked)
    {
        $html = parent::_getCheckboxHtml($value, $checked);

        if ($this->getDisabled()) {
            $html = str_replace('<input type="checkbox"', '<input type="hidden"', $html);
        }

        return $html;
    }
}
