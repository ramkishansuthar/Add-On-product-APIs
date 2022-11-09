<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for most viewed search results.
 * @api
 * @since 1.0.0
 */
interface MostViewedSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get most viewed list.
     *
     * @return \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedInterface[]
     */
    public function getItems();

    /**
     * Set most viewed list.
     *
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
