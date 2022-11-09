<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Model;

use Magento\Framework\Exception\AuthorizationException;

/**
 * AddonAPIs Model
 */
class AddonAPIs
{
    /**
     * @var \WebbyTroops\AddOnProductAPIs\Helper\Data
     */
    protected $helper;
    
    /**
     * Constructor
     *
     * @param \WebbyTroops\AddOnProductAPIs\Helper\Data $helper
     */
    public function __construct(
        \WebbyTroops\AddOnProductAPIs\Helper\Data $helper
    ) {
        $this->helper = $helper;
        $this->checkModuleStatus();
    }
    /**
     * Check module status
     *
     * @throws AuthorizationException
     */
    public function checkModuleStatus()
    {
        if (!$this->helper->isModuleEnable()) {
            throw new AuthorizationException(
                __('You are not authorized to access this resource. Please enable the module first.')
            );
        }
    }
}
