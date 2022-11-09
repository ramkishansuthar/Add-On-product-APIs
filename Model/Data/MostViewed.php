<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model\Data;

use WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedExtensionInterface;

/**
 * MostViewed Data
 */
class MostViewed extends \Magento\Framework\Model\AbstractExtensibleModel implements
    \WebbyTroops\AddOnProductAPIs\Api\Data\MostViewedInterface
{
    /**
     * @inheritdoc
     */
    public function setViews($views)
    {
        return $this->setData(self::LABEL_VIEWS, $views);
    }
    
    /**
     * @inheritdoc
     */
    public function getViews()
    {
        return $this->getData(self::LABEL_VIEWS);
    }
    
    /**
     * @inheritdoc
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::LABEL_ENTITY_ID, $entityId);
    }
    
    /**
     * @inheritdoc
     */
    public function getEntityId()
    {
        return $this->getData(self::LABEL_ENTITY_ID);
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
    public function setExtensionAttributes(MostViewedExtensionInterface $extensionAttributes)
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
