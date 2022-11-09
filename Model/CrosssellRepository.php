<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model;

use WebbyTroops\AddOnProductAPIs\Api\CrosssellApiRepositoryInterface;
use Magento\CatalogInventory\Helper\Stock as StockHelper;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Crosssell Products
 */
class CrosssellRepository extends AddonAPIs implements CrosssellApiRepositoryInterface
{

    /**
     * Items quantity will be capped to this value
     *
     * @var int
     */
    protected $_maxItemCount = 4;

    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $_quoteFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_productVisibility;

    /**
     * @var StockHelper
     */
    protected $stockHelper;

    /**
     * @var \Magento\Catalog\Model\Product\LinkFactory
     */
    protected $_productLinkFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Item\RelatedProducts
     */
    protected $_itemRelationsList;

    /**
     * @var \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;
    
    /**
     * Constructor
     *
     * @param \WebbyTroops\AddOnProductAPIs\Helper\Data $helper
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param \Magento\Catalog\Model\Product\Visibility $productVisibility
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     * @param \Magento\Catalog\Model\Product\LinkFactory $productLinkFactory
     * @param \Magento\Quote\Model\Quote\Item\RelatedProducts $itemRelationsList
     * @param StockHelper $stockHelper
     * @param \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\Config $catalogConfig
     * @codeCoverageIgnore
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \WebbyTroops\AddOnProductAPIs\Helper\Data $helper,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Catalog\Model\Product\LinkFactory $productLinkFactory,
        \Magento\Quote\Model\Quote\Item\RelatedProducts $itemRelationsList,
        StockHelper $stockHelper,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Config $catalogConfig
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->_productVisibility = $productVisibility;
        $this->_quoteFactory = $quoteFactory;
        $this->_productLinkFactory = $productLinkFactory;
        $this->_itemRelationsList = $itemRelationsList;
        $this->stockHelper = $stockHelper;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->quoteId = null;
        $this->_storeManager = $storeManager;
        $this->catalogConfig = $catalogConfig;
        parent::__construct($helper);
    }

    /**
     * @inheritdoc
     */
    public function get($cartId)
    {
        /** @var $quoteIdMask QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        if (!$quoteIdMask->getQuoteId()) {
            throw NoSuchEntityException::singleField('cartId', $cartId);
        }
        return $this->getList($quoteIdMask->getQuoteId());
    }

    /**
     * @inheritDoc
     */
    public function getList($cartId)
    {
        $items = [];
        $this->quoteId = $cartId;
        $ninProductIds = $this->_getCartProductIds();
        if ($ninProductIds) {
            $lastAdded = (int) $this->_getLastAddedProductId();
            if ($lastAdded) {
                $collection = $this->_getCollection()->addProductFilter($lastAdded);
                if (!empty($ninProductIds)) {
                    $collection->addExcludeProductFilter($ninProductIds);
                }
                $collection->setPositionOrder()->load();

                foreach ($collection as $item) {
                    $ninProductIds[] = $item->getId();
                    $items[] = $item;
                }
            }

            if (count($items) < $this->_maxItemCount) {
                $filterProductIds = array_merge(
                    $this->_getCartProductIds(),
                    $this->_itemRelationsList->getRelatedProductIds($this->getQuote()->getAllItems())
                );
                $collection = $this->_getCollection()->addProductFilter(
                    $filterProductIds
                )->addExcludeProductFilter(
                    $ninProductIds
                )->setPageSize(
                    $this->_maxItemCount - count($items)
                )->setGroupBy()->setPositionOrder()->load();
                foreach ($collection as $item) {
                    $items[] = $item;
                }
            }
        }

        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($items);
        return $searchResult;
    }

    /**
     * Get ids of products that are in cart
     *
     * @return array
     */
    protected function _getCartProductIds()
    {
        $ids = [];
        foreach ($this->getQuote()->getAllItems() as $item) {
            $product = $item->getProduct();
            if ($product) {
                $ids[] = $product->getId();
            }
        }
        return $ids;
    }

    /**
     * Get last product ID that was added to cart and remove this information from session
     *
     * @return int
     * @codeCoverageIgnore
     */
    protected function _getLastAddedProductId()
    {
        $lastItemId = null;
        $quoteItems = $this->getQuote()->getAllItems();
        if ($quoteItems) {
            $allItem = end($quoteItems);
            $lastItemId = $allItem->getProductId();
        }
        return $lastItemId;
    }

    /**
     * Get quote instance
     *
     * @return \Magento\Quote\Model\Quote
     * @codeCoverageIgnore
     */
    public function getQuote()
    {
        $quote = null;
        if ($this->quoteId) {
            $quote = $this->_quoteFactory->create()->load($this->quoteId);
        }
        return $quote;
    }

    /**
     * Get crosssell products collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection
     */
    protected function _getCollection()
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection $collection */
        $collection = $this->_productLinkFactory->create()->useCrossSellLinks()
                    ->getProductCollection()->setStoreId(
                        $this->_storeManager->getStore()->getId()
                    )->addStoreFilter()->setPageSize(
                        $this->_maxItemCount
                    )->setVisibility(
                        $this->_productVisibility->getVisibleInCatalogIds()
                    );
        $this->_addProductAttributesAndPrices($collection);

        return $collection;
    }

    /**
     * Add all attributes and apply pricing logic to products collection
     * to get correct values in different products lists.
     * E.g. crosssells, upsells, new products, recently viewed
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected function _addProductAttributesAndPrices(
        \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
    ) {
        return $collection
                    ->addMinimalPrice()
                    ->addFinalPrice()
                    ->addTaxPercents()
                    ->addAttributeToSelect($this->catalogConfig->getProductAttributes())
                    ->addUrlRewrite();
    }
}
