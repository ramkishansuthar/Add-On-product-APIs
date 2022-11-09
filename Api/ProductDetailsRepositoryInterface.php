<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api;

/**
 * Interface ProductDetailsRepositoryInterface
 */
interface ProductDetailsRepositoryInterface
{
    /**
     * Get info about product by product SKU
     *
     * @param string $sku
     * @param string $customerId
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($sku, $customerId);
}
