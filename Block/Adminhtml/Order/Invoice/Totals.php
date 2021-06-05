<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lovevox\CustomerSizeFee\Block\Adminhtml\Order\Invoice;

use Magento\Framework\DataObject;

/**
 * Class Totals
 * @package Lovevox\CustomerSizeFee\Block\Adminhtml
 */
class Totals extends \Magento\Sales\Block\Adminhtml\Order\Invoice\Totals
{
    /**
     * @return \Magento\Sales\Block\Adminhtml\Order\Totals|void
     */
    protected function _initTotals()
    {
        parent::_initTotals();
        $customsizefee = parent::getOrder()->getData('customsizefee');
        if ($customsizefee > 0) {
            // Add our total information to the set of other totals.
            $this->_totals['customsizefee'] = new DataObject(
                [
                    'code' => 'customsizefee',
                    'value' => $customsizefee,
                    'base_value' => $customsizefee,
                    'label' => __('Customization Fees'),
                ]
            );
        }

        $this->_totals['grand_total'] = new DataObject(
            [
                'code' => 'grand_total',
                'strong' => true,
                'value' => parent::getOrder()->getGrandTotal(),
                'base_value' => parent::getOrder()->getBaseGrandTotal(),
                'label' => __('Grand Total'),
                'area' => 'footer',
            ]
        );
    }
}
