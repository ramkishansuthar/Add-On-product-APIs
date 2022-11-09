<?php

/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Api\Data;

/**
 * Interface MostViewedInterface
 */
interface RecentlyViewedInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    public const LABEL_VIEWS = 'views';
    public const LABEL_ENTITY_ID = 'entity_id';
    public const LABEL_CREATED_AT = 'created_at';
    public const LABEL_UPDATED_AT = 'updated_at';

    /**
     * Set Views
     *
     * @param  int $views
     * @return $this
     */
    public function setViews($views);

    /**
     * Get Views
     *
     * @return int
     */
    public function getViews();

    /**
     * Set Entity Id
     *
     * @param  int $entityId
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * Get Entity Id
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Get Updated At
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set Updated At
     *
     * @param  string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set Created At
     *
     * @param  string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \WebbyTroops\AddOnProductAPIs\Api\Data\RecentlyViewedExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \WebbyTroops\AddOnProductAPIs\Api\Data\RecentlyViewedExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(RecentlyViewedExtensionInterface $extensionAttributes);
}
