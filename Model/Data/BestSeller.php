<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model\Data;

use WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerExtensionInterface;

/**
 * BestSeller Data
 */
class BestSeller extends \Magento\Framework\Model\AbstractExtensibleModel implements
    \WebbyTroops\AddOnProductAPIs\Api\Data\BestSellerInterface
{
    /**
     * @inheritdoc
     */
    public function setPeriod($period)
    {
        return $this->setData(self::LABEL_PERIOD, $period);
    }
    
    /**
     * @inheritdoc
     */
    public function getPeriod()
    {
        return $this->getData(self::LABEL_PERIOD);
    }
    
    /**
     * @inheritdoc
     */
    public function setQtyOrdered($qtyOrdered)
    {
        return $this->setData(self::LABEL_QTY_ORDERED, $qtyOrdered);
    }
    
    /**
     * @inheritdoc
     */
    public function getQtyOrdered()
    {
        return $this->getData(self::LABEL_QTY_ORDERED);
    }
    
    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(BestSellerExtensionInterface $extensionAttributes)
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
