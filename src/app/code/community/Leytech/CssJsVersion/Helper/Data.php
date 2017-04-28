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
    const XML_PATH_APPEND_VERSION = 'leytech_cssjsversion/settings/append_version';

    protected $_appendVersion;

    public function isEnabled() {
        return Mage::getStoreConfig(self::XML_PATH_IS_ENABLED);
    }

    protected function getAppendVersion() {
        if(!$this->_appendVersion) {
            return Mage::getStoreConfig(self::XML_PATH_APPEND_VERSION);
        }
        return $this->_appendVersion;
    }

    public function appendVersionToTags($html) {

        $doc = new DOMDocument();

        // DOMDocument absolutely hates us all (ref: http://stackoverflow.com/a/29499398/2929617)
        $doc->loadHTML("<div>$html</div>", LIBXML_HTML_NODEFDTD);
        $container = $doc->getElementsByTagName('div')->item(0);
        $container = $container->parentNode->removeChild($container);
        while ($doc->firstChild) {
            $doc->removeChild($doc->firstChild);
        }
        while ($container->firstChild ) {
            $doc->appendChild($container->firstChild);
        }

        // Process all the script tags
        foreach($doc->getElementsByTagName('script') as $script) {
            if($script->hasAttribute('src')) {
                $script->setAttribute('src', $script->getAttribute('src') . "?v" . $this->getAppendVersion());
            }
        }

        // Process all the link tags (stylesheets)
        foreach($doc->getElementsByTagName('link') as $link) {
            if($link->hasAttribute('href') && $link->hasAttribute('rel')) {
                if($link->getAttribute('rel') == 'stylesheet') {
                    $link->setAttribute('href', $link->getAttribute('href') . "?v" . $this->getAppendVersion());
                }
            }
        }

        return $doc->saveHTML();
    }
}