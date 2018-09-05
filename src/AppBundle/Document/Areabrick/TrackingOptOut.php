<?php

namespace AppBundle\Document\Areabrick;

class TrackingOptOut extends AbstractAreabrick
{
    public function getName()
    {
        return 'Tracking OptOut';
    }

    public function getDescription()
    {
        return 'OptOut element for Datenschutz';
    }

    public function getTemplateLocation()
    {
        return static::TEMPLATE_LOCATION_GLOBAL;
    }
}