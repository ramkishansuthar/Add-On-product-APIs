<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api;

/**
 * Interface RecentlyViewedApiRepositoryInterface
 */
interface RecentlyViewedApiRepositoryInterface
{
    /**
     * Get recently viewed products
     *
     * @param int $customerId
     * @param int $pageSize
     * @param int $curPage
     * @return \WebbyTroops\AddOnProductAPIs\Api\Data\RecentlyViewedSearchResultsInterface
     */
    public function getList($customerId, $pageSize = 0, $curPage = 0);
}
