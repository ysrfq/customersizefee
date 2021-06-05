<?php

namespace Lovevox\CustomerSizeFee\Observer;

class SalesOrderCustomerSzieFeeObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $quoteRepository;

    protected $objectManager;

    protected $logger;

    /**
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Quote\Model\QuoteRepository $quoteRepository
    )
    {
        $this->quoteRepository = $quoteRepository;
        $this->objectManager = $objectManager;
        $this->logger = $logger;
    }

    /**
     * transfer the order comment from the quote object to the order object during the
     * sales_model_service_quote_submit_before event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
//        $this->logger->info("SalesOrderCustomerSzieFeeObserver===================>".$order->getId());
        if ($order->getId()) {
            /** @var $quote \Magento\Quote\Model\Quote */
            $quote = $this->quoteRepository->get($order->getQuoteId());
            $customsizefee = $quote->getData('customsizefee');
//            $this->logger->info("customsizefee===================>".$customsizefee);
            $order->setData('customsizefee',$customsizefee);
            $order->save();
        }
    }
}
