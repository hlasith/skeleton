<?php
/**
 * Created by PhpStorm.
 * User: ZhaWa
 * Date: 25.06.2018
 * Time: 15:12
 */

namespace AppBundle\Tool;

class Piwik
{
    public static function isEnabled() : bool
    {
        return \Pimcore::getContainer()->hasParameter('piwik.enable')
            && \Pimcore::getContainer()->getParameter('piwik.enable');
    }

    public static function getHostname()
    {
        if (self::isEnabled()) {
            return \Pimcore::getContainer()->getParameter('piwik.hostname');
        }
        return '';
    }

    public static function getSiteId()
    {
        if (self::isEnabled()) {
            return \Pimcore::getContainer()->getParameter('piwik.siteId');
        }
        return '';
    }

    public static function getJsFilePath()
    {
        if (self::isEnabled()) {
            return \Pimcore::getContainer()->getParameter('piwik.jsFilePath');
        }
        return '';
    }
}