<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for compare products search results.
 * @api
 * @since 1.0.0
 */
interface CompareProductsSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get compare products list.
     *
     * @return \WebbyTroops\AddOnProductAPIs\Api\Data\CompareProductsInterface[]
     */
    public function getItems();

    /**
     * Set compare products list.
     *
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\CompareProductsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
