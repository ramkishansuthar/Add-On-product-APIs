<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api;

/**
 * Interface CrosssellApiRepositoryInterface
 */
interface CrosssellApiRepositoryInterface
{
    /**
     * Get Cross-sell products
     *
     * @param int $cartId
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getList($cartId);

    /**
     * Get Cross-sell products
     *
     * @param string $cartId
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function get($cartId);
}
