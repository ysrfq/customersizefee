<?php

namespace Lovevox\CustomerSizeFee\Observer;

class SalesOrderInvoiceCustomerSzieFeeObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $orderRepository;

    protected $objectManager;

    protected $logger;

    /**
     * SalesOrderInvoiceCustomerSzieFeeObserver constructor.
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Sales\Model\OrderRepository $orderRepository
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Model\OrderRepository $orderRepository
    )
    {
        $this->orderRepository = $orderRepository;
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
        /** @var \Magento\Sales\Model\Order\Invoice $invoice */
        $invoice = $observer->getData('invoice');
//        $this->logger->info("SalesOrderInvoiceCustomerSzieFeeObserver===================>" . $invoice->getId());
        if ($invoice->getId()) {
            /** @var $order \Magento\Sales\Model\Order */
            $order = $this->orderRepository->get($invoice->getOrderId());
            $customsizefee = $order->getData('customsizefee');
            if ($invoice->getData('customsizefee') == 0 && $customsizefee > 0) {
                $grand_total = $invoice->getGrandTotal() + $customsizefee;
                $base_grand_total = $invoice->getBaseGrandTotal() + $customsizefee;
                $invoice->setData('customsizefee', $customsizefee);
                $invoice->setGrandTotal($grand_total);
                $invoice->setBaseGrandTotal($base_grand_total);
//                $this->logger->info("setCustomsizefee===================>" . $customsizefee);
//                $this->logger->info("setGrandTotal===================>" . $grand_total);
//                $this->logger->info("setBaseGrandTotal===================>" . $base_grand_total);
                $invoice->save();
            }
        }
    }
}
