<?php
/**
 * Copyright © WebbyTroops Technologies. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace WebbyTroops\AddOnProductAPIs\Helper;

use Magento\Store\Model\ScopeInterface;

/**
 * AddOn API Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * const Section id
     */
    public const SECTION_ID = 'addonapis';
    
    /**
     * const CONFIG_ENABLED_PATH
     */
    public const CONFIG_ENABLED_PATH = 'general/enable';
    
    /**
     *
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    protected $resourceConfig;
    
    /**
     *
     * @var \Magento\Config\Model\Config
     */
    protected $config;
    
    /**
     *
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    protected $encryptor;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Config\Model\ResourceModel\Config $resourceConfig
     * @param \Magento\Config\Model\Config $config
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Config\Model\ResourceModel\Config $resourceConfig,
        \Magento\Config\Model\Config $config
    ) {
        $this->resourceConfig = $resourceConfig;
        $this->config = $config;
        parent::__construct($context);
    }
    
    /**
     * Get module section ID
     *
     * @return string
     */
    public function getSectionId()
    {
        return self::SECTION_ID;
    }

    /**
     * Disable module
     *
     * @return void
     */
    public function disableModule()
    {
        $this->resourceConfig->deleteConfig(self::SECTION_ID . '/' . self::CONFIG_ENABLED_PATH);
        $this->config->setDataByPath(self::SECTION_ID . '/' . self::CONFIG_ENABLED_PATH, 0);
        $this->config->save();
    }

    /**
     * Check if module enable from configuraion
     *
     * @return bool
     */
    public function isModuleEnable()
    {
        return $this->getConfig(self::SECTION_ID.'/'.self::CONFIG_ENABLED_PATH);
    }
    
    /**
     * Get config value
     *
     * @param string $path
     * @param string|int $store
     * @param string|null $scope
     * @return mixed
     */
    public function getConfig($path, $store = null, $scope = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }
}
