<?php
/**
 * @package    Leytech_CssJsVersion
 * @author     Chris Nolan (chris@leytech.co.uk)
 * @copyright  Copyright (c) 2017 Leytech
 * @license    https://opensource.org/licenses/MIT  The MIT License  (MIT)
 */

class Leytech_CssJsVersion_Model_Observer
{
    public function processBlockHtml(Varien_Event_Observer $observer)
    {
        Varien_Profiler::start('leytech_cssjsversion');

        $helper = Mage::helper('leytech_cssjsversion');

        if (!$helper->isEnabled()) {
            Varien_Profiler::stop('leytech_cssjsversion');
            return $this;
        }

        $transport = $observer->getTransport();
        $block = $observer->getBlock();

        if ($block->getNameInLayout() == 'head') {
            $transport->setHtml($helper->appendVersionToTags($transport->getHtml()));
        }

        Varien_Profiler::stop('leytech_cssjsversion');

        return $this;
    }

    public function updateVersion()
    {
        $helper = Mage::helper('leytech_cssjsversion');
        $helper->updateVersion();
        return $this;
    }
}