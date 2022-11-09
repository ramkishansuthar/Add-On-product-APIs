<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model;

/**
 * Recently Viewed Products
 */
class RecentlyViewedCore extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * Product Index model type
     *
     * @var string
     */
    protected $indexType;

    /**
     * Product Index Collection
     *
     * @var \Magento\Reports\Model\ResourceModel\Product\Index\Collection\AbstractCollection
     */
    protected $collection;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $productVisibility;

    /**
     * @var \Magento\Reports\Model\Product\Index\Factory
     */
    protected $indexFactory;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Model\Product\Visibility $productVisibility
     * @param \Magento\Reports\Model\Product\Index\Factory $indexFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        \Magento\Reports\Model\Product\Index\Factory $indexFactory,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $data
        );
        $this->productVisibility = $productVisibility;
        $this->indexFactory = $indexFactory;
        $this->isScopePrivate = true;
    }

    /**
     * Retrieve page size
     *
     * @return int
     */
    public function getPageSize()
    {
        if ($this->hasData('page_size')) {
            return $this->getData('page_size');
        }
        return 5;
    }
    
    /**
     * Retrieve page size
     *
     * @return int
     */
    public function getCurPage()
    {
        if ($this->hasData('cur_page')) {
            return $this->getData('cur_page');
        }
        return 5;
    }

    /**
     * Retrieve product ids, that must not be included in collection
     *
     * @return array
     */
    protected function _getProductsToSkip()
    {
        return [];
    }

    /**
     * Public method for retrieve Product Index model
     *
     * @return \Magento\Reports\Model\Product\Index\AbstractIndex
     */
    public function getModel()
    {
        try {
            $model = $this->indexFactory->get('viewed');
        } catch (\InvalidArgumentException $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Index type is not valid'));
        }

        return $model;
    }

    /**
     * Retrieve Index Product Collection
     *
     * @return \Magento\Reports\Model\ResourceModel\Product\Index\Collection\AbstractCollection
     */
    public function getItemsCollection()
    {
        if ($this->collection === null) {
            $attributes = $this->_catalogConfig->getProductAttributes();

            $this->collection = $this->getModel()->getCollection()->addAttributeToSelect($attributes);

            if ($this->getCustomerId()) {
                $this->collection->setCustomerId($this->getCustomerId());
            }

            $this->collection->excludeProductIds(
                $this->getModel()->getExcludeProductIds()
            )->addUrlRewrite()->setPageSize(
                $this->getPageSize()
            )->setCurPage(
                $this->getCurPage()
            );

            /* Price data is added to consider item stock status using price index */
            $this->collection->addPriceData();

            $ids = $this->getProductIds();
            if (empty($ids)) {
                $this->collection->addIndexFilter();
            } else {
                $this->collection->addFilterByIds($ids);
            }
            $this->collection->setAddedAtOrder()->setVisibility($this->productVisibility->getVisibleInSiteIds());
        }

        return $this->collection;
    }

    /**
     * Retrieve count of product index items
     *
     * @return int
     */
    public function getCount()
    {
        if (!$this->getModel()->getCount()) {
            return 0;
        }
        return $this->getItemsCollection()->getSize();
    }
}
