<?php
/**
 * Created by PhpStorm.
 * User: ThoMa
 * Date: 19.06.2018
 * Time: 10:10
 */

namespace AppBundle\Document\Areabrick;

use Pimcore\Model\Document\Tag\Area\Info;
use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;

class NewsCollection extends AbstractTemplateAreabrick
{
    public function getName()
    {
        return 'NewsCollection';
    }

    public function getDescription()
    {
        return 'Add a news collection block.';
    }

    public function getTemplateLocation()
    {
        return static::TEMPLATE_LOCATION_GLOBAL;
    }

    public function getHtmlTagOpen(Info $info)
    {
        if($info->index == 0) {
            return '<section class="mt-4"><div>';
        }

        return '<section class="mt-4"><div>';
    }

    /**
     * {@inheritdoc}
     */
    public function getHtmlTagClose(Info $info)
    {
        return '</div></section>';
    }
}