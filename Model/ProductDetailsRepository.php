<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model;

use WebbyTroops\AddOnProductAPIs\Api\ProductDetailsRepositoryInterface;

/**
 * Product Details
 */
class ProductDetailsRepository extends AddonAPIs implements ProductDetailsRepositoryInterface
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    
    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager;
    
    /**
     * @param \WebbyTroops\AddOnProductAPIs\Helper\Data $helper
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     */
    public function __construct(
        \WebbyTroops\AddOnProductAPIs\Helper\Data $helper,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Event\ManagerInterface $eventManager
    ) {
        $this->productRepository = $productRepository;
        $this->eventManager = $eventManager;
        parent::__construct($helper);
    }
    /**
     * @inheritDoc
     */
    public function get($sku, $customerId)
    {
        $product = $this->productRepository->get($sku);
        if ($customerId) {
            $this->eventManager->dispatch(
                'loggedin_user_recently_viewed_event_apis',
                ['product_id' => $product->getId(), 'customer_id' => $customerId]
            );
        }
        return $product;
    }
}
