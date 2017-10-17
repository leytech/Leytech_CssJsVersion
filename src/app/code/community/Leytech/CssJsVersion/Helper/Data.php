<?php
/**
 * @package    Leytech_CssJsVersion
 * @author     Chris Nolan (chris@leytech.co.uk)
 * @copyright  Copyright (c) 2017 Leytech
 * @license    https://opensource.org/licenses/MIT  The MIT License  (MIT)
 */

class Leytech_CssJsVersion_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_IS_ENABLED = 'leytech_cssjsversion/settings/enabled';
    const XML_PATH_AUTO_UPDATE = 'leytech_cssjsversion/settings/auto_update';
    const XML_PATH_APPEND_VERSION = 'leytech_cssjsversion/settings/append_version';

    protected $_enabled;

    protected $_autoUpdate;

    protected $_appendVersion;

    public function isEnabled()
    {
        if (!isset($this->_enabled)) {
            return (bool)Mage::getStoreConfig(self::XML_PATH_IS_ENABLED);
        }
        return $this->_enabled;
    }

    protected function getAutoUpdate()
    {
        if (!isset($this->_autoUpdate)) {
            return Mage::getStoreConfig(self::XML_PATH_AUTO_UPDATE);
        }
        return $this->_autoUpdate;
    }

    protected function getAppendVersion()
    {
        if (!isset($this->_appendVersion)) {
            return Mage::getStoreConfig(self::XML_PATH_APPEND_VERSION);
        }
        return $this->_appendVersion;
    }

    protected function getAppendVersionString()
    {
        return "?v=" . $this->getAppendVersion();
    }

    public function appendVersionToTags($html)
    {

        // CSS
        $html = preg_replace_callback(
            "/href=['\"][^'\"]+?\.css[^'\"]*/",
            function ($matches) {
                return $matches[0] . $this->getAppendVersionString();
            },
            $html
        );

        // JS
        $html = preg_replace_callback(
            "/src=['\"][^'\"]+?\.js[^'\"]*/",
            function ($matches) {
                return $matches[0] . $this->getAppendVersionString();
            },
            $html
        );

        return $html;
    }

    public function updateVersion()
    {
        if ($this->isEnabled() && $this->getAutoUpdate()) {
            $dateTime = date_timestamp_get(new DateTime());
            Mage::getConfig()->saveConfig(self::XML_PATH_APPEND_VERSION, $dateTime);
        }
    }
}