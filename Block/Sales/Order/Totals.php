<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lovevox\CustomerSizeFee\Block\Sales\Order;

/**
 * Class Totals
 * @package Lovevox\CustomerSizeFee\Block\Sales\Order
 */
class Totals extends \Magento\Framework\View\Element\Template
{

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get totals source object
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * Create the weee ("FPT") totals summary
     *
     * @return $this
     */
    public function initTotals()
    {
        $customsizefee = $this->getSource()->getData('customsizefee');
        if ($customsizefee >0) {
            // Add our total information to the set of other totals
            $total = new \Magento\Framework\DataObject(
                [
                    'code' => 'customsizefee',
                    'field' => 'customsizefee',
                    'value' => $customsizefee,
                    'label' => __('Customization Fees'),
                ]
            );
            $this->getParentBlock()->addTotalBefore($total, 'grand_total');
        }
        return $this;
    }
}
