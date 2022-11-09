<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api\Data;

/**
 * Interface BestSellerInterface
 */
interface BestSellerInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    public const LABEL_PERIOD = 'views';
    public const LABEL_QTY_ORDERED = 'entity_id';
    
    /**
     * Set Views
     *
     * @param  string $period
     * @return $this
     */
    public function setPeriod($period);
    
    /**
     * Get Views
     *
     * @return string
     */
    public function getPeriod();
    
    /**
     * Set Quantity Ordered
     *
     * @param  int $qtyOrdered
     * @return $this
     */
    public function setQtyOrdered($qtyOrdered);
    
    /**
     * Get Quantity Ordered
     *
     * @return int
     */
    public function getQtyOrdered();
    
    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerExtensionInterface|null
     */
    public function getExtensionAttributes();
    
    /**
     * Set an extension attributes object.
     *
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(BestSellerExtensionInterface $extensionAttributes);
}
