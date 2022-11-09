<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model;

use WebbyTroops\AddOnProductAPIs\Api\RecentlyViewedApiRepositoryInterface;

/**
 * Recently Viewed Product Repository
 */
class RecentlyViewedRepository extends AddonAPIs implements RecentlyViewedApiRepositoryInterface
{

    /**
     * @var \WebbyTroops\AddOnProductAPIs\Model\RecentlyViewedCoreFactory
     */
    protected $recentlyViewedProducts;
    
    /**
     * @var \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;
    
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    
    /**
     * @param \WebbyTroops\AddOnProductAPIs\Helper\Data $helper
     * @param \WebbyTroops\AddOnProductAPIs\Model\RecentlyViewedCoreFactory $recentlyViewedProducts
     * @param \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \WebbyTroops\AddOnProductAPIs\Helper\Data $helper,
        \WebbyTroops\AddOnProductAPIs\Model\RecentlyViewedCoreFactory $recentlyViewedProducts,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->recentlyViewedProducts = $recentlyViewedProducts;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepository = $productRepository;
        parent::__construct($helper);
    }

    /**
     * @inheritDoc
     */
    public function getList($customerId, $pageSize = 0, $curPage = 0)
    {
        $products = [];
        if ($customerId) {
            $recentProducts = $this->recentlyViewedProducts->create();
            $recentProducts->setCustomerId($customerId);
            $recentProducts->setPageSize($pageSize);
            $recentProducts->setCurPage($curPage);
            $collection = $recentProducts->getItemsCollection();

            $productIds = [];
            foreach ($collection as $product) {
                $productIds[] = $product->getProductId();
            }
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('entity_id', $productIds, 'in')->create();
            $products = $this->productRepository->getList($searchCriteria);
        }
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($products->getItems());
        $searchResults->setTotalCount($products->getTotalCount());

        return $searchResults;
    }
}
