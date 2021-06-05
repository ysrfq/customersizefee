<?php

namespace Lovevox\CustomerSizeFee\Model\Quote\Address\Total;

class CustomerSizeFee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;


    //const customersize_price = 14.99;

    protected $objectManager;

    protected $logger;

    /**
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_priceCurrency = $priceCurrency;
        $this->objectManager = $objectManager;
        $this->logger = $logger;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);
        $customer_prices = $this->getCustomerSizePrice($quote);
        if ($customer_prices != 0) {
            $total->addTotalAmount('customsizefee', $customer_prices);
            $total->addBaseTotalAmount('customsizefee', $customer_prices);
            $quote->setData('customsizefee', $customer_prices);
            $quote->save();
//            $this->logger->info("setHandlingFee=====>" . $customer_prices);
        }
        return $this;
    }

    public function fetch(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        return [
            'code' => 'customsizefee',
            'title' => $this->getLabel(),
            'value' => $quote->getData('customsizefee')
        ];
    }

    /**
     * get label
     * @return string
     */
    public function getLabel()
    {
        return __('Customization Fees');
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     */
    protected function getCustomerSizePrice($quote)
    {
//        $this->logger->info("getItemsCount=====>" . count($quote->getAllItems()));
        $prices = 0;
        foreach ($quote->getAllItems() as $item) {
//            $this->logger->info("getItemId=====>" . $item->getItemId());
            $info_buyRequest = json_decode($item->getOptionByCode('info_buyRequest')->getValue(), true);
//            $this->logger->info("info_buyRequest=====>" . isset($info_buyRequest['customsize']));
            if (isset($info_buyRequest['customsize'])) {
                $prices += $info_buyRequest['customize_price'] * $item->getQty();
            }
        }
//        $this->logger->info("prices=====>" . $prices);
        return $prices;
    }
}
