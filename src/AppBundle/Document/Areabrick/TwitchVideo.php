<?php
/**
 * Created by PhpStorm.
 * User: ThoMa
 * Date: 19.06.2018
 * Time: 10:10
 */

namespace AppBundle\Document\Areabrick;

class TwitchVideo extends AbstractAreabrick
{
    public function getName()
    {
        return 'TwitchVideo';
    }

    public function getDescription()
    {
        return 'Embed Twitch live streams, VODs, and clips in an IFrame';
    }

    public function getTemplateLocation()
    {
        return static::TEMPLATE_LOCATION_GLOBAL;
    }
}