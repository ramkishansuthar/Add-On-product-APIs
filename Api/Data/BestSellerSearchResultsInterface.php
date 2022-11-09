<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for best seller search results.
 * @api
 * @since 1.0.0
 */
interface BestSellerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get best seller list.
     *
     * @return \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerInterface[]
     */
    public function getItems();

    /**
     * Set best seller list.
     *
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
