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

    public function getVersionUrl($url)
    {
        if ($this->isEnabled()) {
            return $url . $this->getAppendVersionString();
        } else {
            return $url;
        }
    }

    public function appendVersionToTags($html)
    {
        // DOMDocument absolutely hates us all (ref: http://stackoverflow.com/a/29499398/2929617)
        $doc = new DOMDocument();
        $doc->loadHTML("<div>$html</div>", LIBXML_HTML_NODEFDTD);
        $container = $doc->getElementsByTagName('div')->item(0);
        $container = $container->parentNode->removeChild($container);
        while ($doc->firstChild) {
            $doc->removeChild($doc->firstChild);
        }
        while ($container->firstChild) {
            $doc->appendChild($container->firstChild);
        }

        // Process all the script tags
        foreach ($doc->getElementsByTagName('script') as $script) {
            if ($script->hasAttribute('src')) {
                $script->setAttribute('src', $script->getAttribute('src') . $this->getAppendVersionString());
            }
        }

        // Process all the link tags (stylesheets)
        foreach ($doc->getElementsByTagName('link') as $link) {
            if ($link->hasAttribute('href') && $link->hasAttribute('rel')) {
                if ($link->getAttribute('rel') == 'stylesheet') {
                    $link->setAttribute('href', $link->getAttribute('href') . $this->getAppendVersionString());
                }
            }
        }

        return $doc->saveHTML();
    }

    public function updateVersion()
    {
        if ($this->isEnabled() && $this->getAutoUpdate()) {
            $dateTime = date_timestamp_get(new DateTime());
            Mage::getConfig()->saveConfig(self::XML_PATH_APPEND_VERSION, $dateTime);
        }
    }
}