<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model\Data;

use WebbyTroops\AddOnProductAPIs\Api\Data\CompareProductsExtensionInterface;

/**
 * CompareProducts Data
 */
class CompareProducts extends \Magento\Framework\Model\AbstractExtensibleModel implements
    \WebbyTroops\AddOnProductAPIs\Api\Data\CompareProductsInterface
{
    /**
     * @inheritdoc
     */
    public function setCompareItemId($compareItemId)
    {
        return $this->setData(self::LABEL_COMPARE_ITEM_ID, $compareItemId);
    }
    
    /**
     * @inheritdoc
     */
    public function getCompareItemId()
    {
        return $this->getData(self::LABEL_COMPARE_ITEM_ID);
    }
    
    /**
     * @inheritdoc
     */
    public function setCustomerId($customerId = null)
    {
        return $this->setData(self::LABEL_CUSTOMER_ID, $customerId);
    }
    
    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->getData(self::LABEL_CUSTOMER_ID);
    }
    
    /**
     * @inheritdoc
     */
    public function setVisitorId($visitorId)
    {
        return $this->setData(self::LABEL_VISITOR_ID, $visitorId);
    }
    
    /**
     * @inheritdoc
     */
    public function getVisitorId()
    {
        return $this->getData(self::LABEL_VISITOR_ID);
    }
    
    /**
     * @inheritdoc
     */
    public function setItemStoreId($itemStoreId)
    {
        return $this->setData(self::LABEL_ITEM_STORE_ID, $itemStoreId);
    }
    
    /**
     * @inheritdoc
     */
    public function getItemStoreId()
    {
        return $this->getData(self::LABEL_ITEM_STORE_ID);
    }
    
    /**
     * @inheritdoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::LABEL_CREATED_AT, $createdAt);
    }
    
    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::LABEL_CREATED_AT);
    }
    
    /**
     * @inheritdoc
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::LABEL_UPDATED_AT, $updatedAt);
    }
    
    /**
     * @inheritdoc
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::LABEL_UPDATED_AT);
    }
    
    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(CompareProductsExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }
}
