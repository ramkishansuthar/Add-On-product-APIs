<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api;

/**
 * Interface BestSellerRepositoryInterface
 */
interface BestSellerRepositoryInterface
{
    /**
     * Get Best Seller products
     *
     * @param string $period
     * @param int $limit
     * @return \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerSearchResultsInterface
     */
    public function getList($period = 'yearly', $limit = 10);
}
