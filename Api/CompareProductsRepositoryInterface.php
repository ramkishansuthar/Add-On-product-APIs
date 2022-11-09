<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api;

/**
 * Interface CompareProductsRepositoryInterface
 */
interface CompareProductsRepositoryInterface
{
    /**
     * Get compare products
     *
     * @param int $customerId
     * @param int $limit
     * @return \WebbyTroops\AddOnProductAPIs\Api\Data\CompareProductsSearchResultsInterface
     */
    public function getList($customerId, $limit = 10);
}
