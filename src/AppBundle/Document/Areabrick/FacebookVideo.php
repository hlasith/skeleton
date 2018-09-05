<?php
/**
 * Created by PhpStorm.
 * User: ThoMa
 * Date: 19.06.2018
 * Time: 10:10
 */

namespace AppBundle\Document\Areabrick;

class FacebookVideo extends AbstractAreabrick
{
    public function getName()
    {
        return 'FacebookVideo';
    }

    public function getDescription()
    {
        return 'Embed Facebook videos in an IFrame';
    }

    public function getTemplateLocation()
    {
        return static::TEMPLATE_LOCATION_GLOBAL;
    }
}