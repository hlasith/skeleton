<?php
/**
 * Created by PhpStorm.
 * User: ZhaWa
 * Date: 25.06.2018
 * Time: 15:12
 */

namespace AppBundle\Tool;

class GoogleAnalytics
{
    public static function isEnabled() : bool
    {
        return \Pimcore::getContainer()->hasParameter('googleAnalytics.enable')
            && \Pimcore::getContainer()->getParameter('googleAnalytics.enable');
    }

    public static function getHostname()
    {
        if (self::isEnabled()) {
            return \Pimcore::getContainer()->getParameter('googleAnalytics.hostname');
//            return str_replace("%id%", self::getSiteId(), $tmp);
        }
        return '';
    }

    public static function getSiteId()
    {
        if (self::isEnabled()) {
            return \Pimcore::getContainer()->getParameter('googleAnalytics.siteId');
        }
        return '';
    }
}