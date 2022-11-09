<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Catalog ProductView Recorder
 */
class CatalogProductViewObserver implements ObserverInterface
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Reports\Model\Product\Index\ViewedFactory
     */
    protected $productIndexFactory;

    /**
     * @var \Magento\Reports\Model\EventFactory
     */
    protected $eventFactory;

    /**
     * Constructor
     *
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Reports\Model\Product\Index\ViewedFactory $productIndexFactory
     * @param \Magento\Reports\Model\EventFactory $eventFactory
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Reports\Model\Product\Index\ViewedFactory $productIndexFactory,
        \Magento\Reports\Model\EventFactory $eventFactory
    ) {
        $this->storeManager = $storeManager;
        $this->productIndexFactory = $productIndexFactory;
        $this->eventFactory = $eventFactory;
    }

    /**
     * View Catalog Product action
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $viewData['product_id'] = $observer->getEvent()->getProductId();
        $viewData['store_id']   = $this->storeManager->getStore()->getId();
        $viewData['customer_id'] = $observer->getEvent()->getCustomerId();
        $this->productIndexFactory->create()->setData($viewData)->save()->calculate();
        
        $eventModel = $this->eventFactory->create();
        
        $eventModel->setData([
            'event_type_id' => \Magento\Reports\Model\Event::EVENT_PRODUCT_VIEW,
            'object_id' => $viewData['product_id'],
            'subject_id' => $viewData['customer_id'],
            'subtype' => 0,
            'store_id' => $viewData['store_id'],
        ]);

        $eventModel->save();
    }
}
