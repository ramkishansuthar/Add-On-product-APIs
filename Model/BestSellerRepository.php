<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model;

use WebbyTroops\AddOnProductAPIs\Api\BestSellerRepositoryInterface;

/**
 * Best Seller Products
 */
class BestSellerRepository extends AddonAPIs implements BestSellerRepositoryInterface
{

    /**
     * @var \Magento\Reports\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;
    
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    
    /**
     * @var \WebbyTroops\BestSellerAPI\Api\Data\BestSellerInterfaceFactory
     */
    protected $bestSellerInterfaceFactory;
    
    /**
     * @var \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerExtensionInterfaceFactory
     */
    protected $bestSellerExtension;
    
    /**
     * @var \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * Constructor
     *
     * @param \WebbyTroops\AddOnProductAPIs\Helper\Data $helper
     * @param \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $bestSellerCollectionFactory
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerInterfaceFactory $bestSellerInterfaceFactory
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerExtensionInterfaceFactory $bestSellerExtension
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \WebbyTroops\AddOnProductAPIs\Helper\Data $helper,
        \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $bestSellerCollectionFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerInterfaceFactory $bestSellerInterfaceFactory,
        \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerExtensionInterfaceFactory $bestSellerExtension,
        \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->collectionFactory = $bestSellerCollectionFactory;
        $this->productRepository = $productRepository;
        $this->bestSellerInterfaceFactory = $bestSellerInterfaceFactory;
        $this->bestSellerExtension = $bestSellerExtension;
        $this->searchResultsFactory = $searchResultsFactory;
        parent::__construct($helper);
    }

    /**
     * @inheritDoc
     */
    public function getList($period = 'yearly', $limit = 10)
    {
        $collections = $this->collectionFactory->create()
                    ->setPeriod($period)
                    ->setPageSize($limit);
        
        $data = [];
        foreach ($collections as $collection) {
            $bestSeller = $this->bestSellerInterfaceFactory->create();
            $bestSeller->setPeriod($collection->getPeriod());
            $bestSeller->setEntityId($collection->getQtyOrdered());
            $product = $this->productRepository->getById($collection->getProductId());
            $extensionAttributes = $bestSeller->getExtensionAttributes();
            if ($extensionAttributes === null) {
                $extensionAttributes = $this->bestSellerExtension->create();
            }
            $extensionAttributes->setProduct($product);
            $bestSeller->setExtensionAttributes($extensionAttributes);
            $data[] = $bestSeller;
        }
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($data);
        $searchResults->setTotalCount($collections->count());
        return $searchResults;
    }
}
