<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model;

use WebbyTroops\AddOnProductAPIs\Api\MostViewedRepositoryInterface;
 
/**
 * Most Viewed Product
 */
class MostViewedRepository extends AddonAPIs implements MostViewedRepositoryInterface
{
    /**
     * @var \Magento\Reports\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productsFactory;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    
    /**
     * @var \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedInterfaceFactory
     */
    protected $mostViewedInterfaceFactory;
    
    /**
     * @var \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedExtensionInterfaceFactory
     */
    protected $mostViewedExtension;
    
    /**
     * @var \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    
    /**
     * @param \WebbyTroops\AddOnProductAPIs\Helper\Data $helper
     * @param \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $productsFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedInterfaceFactory $mostViewedInterfaceFactory
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedExtensionInterfaceFactory $mostViewedExtension
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \WebbyTroops\AddOnProductAPIs\Helper\Data $helper,
        \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $productsFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedInterfaceFactory $mostViewedInterfaceFactory,
        \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedExtensionInterfaceFactory $mostViewedExtension,
        \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->productsFactory = $productsFactory;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->mostViewedInterfaceFactory = $mostViewedInterfaceFactory;
        $this->mostViewedExtension = $mostViewedExtension;
        $this->searchResultsFactory = $searchResultsFactory;
        parent::__construct($helper);
    }

    /**
     * @inheritDoc
     */
    public function getList($limit = 10)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $collections = $this->productsFactory->create()->addAttributeToSelect(
            'entity_id',
            'views'
        )->addViewsCount()->setStoreId(
            $storeId
        )->addStoreFilter(
            $storeId
        )->setPageSize(
            $limit
        );
        $data = [];
        foreach ($collections as $collection) {
            $mostViewed = $this->mostViewedInterfaceFactory->create();
            $mostViewed->setViews($collection->getViews());
            $mostViewed->setEntityId($collection->getEntityId());
            $mostViewed->setCretedAt($collection->getCreatedAt());
            $mostViewed->setUpdatedAt($collection->getUpdatedAt());
            $product = $this->productRepository->get($collection->getSku());
            $extensionAttributes = $mostViewed->getExtensionAttributes();
            if ($extensionAttributes === null) {
                $extensionAttributes = $this->mostViewedExtension->create();
            }
            $extensionAttributes->setProduct($product);
            $mostViewed->setExtensionAttributes($extensionAttributes);
            $data[] = $mostViewed;
        }
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($data);
        $searchResults->setTotalCount($collections->count());
     
        return $searchResults;
    }
}
