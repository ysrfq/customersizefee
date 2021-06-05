<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lovevox\CustomerSizeFee\Block\Adminhtml;

use Magento\Framework\DataObject;

/**
 * Class Totals
 * @package Lovevox\CustomerSizeFee\Block\Adminhtml
 */
class Totals extends \Magento\Sales\Block\Adminhtml\Order\Totals
{
    /**
     * @return \Magento\Sales\Block\Adminhtml\Order\Totals|void
     */
    protected function _initTotals()
    {
        parent::_initTotals();
        $customsizefee = $this->getSource()->getData('customsizefee');
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
    }
}
