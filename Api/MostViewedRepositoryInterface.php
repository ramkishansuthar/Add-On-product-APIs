<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api;

/**
 * Interface MostViewedRepositoryInterface
 */
interface MostViewedRepositoryInterface
{
    /**
     * Get most viewed products
     *
     * @param int $limit
     * @return \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedSearchResultsInterface
     */
    public function getList($limit = 10);
}
