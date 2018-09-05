<?php
/**
 * Created by PhpStorm.
 * User: ThoMa
 * Date: 19.06.2018
 * Time: 10:10
 */

namespace AppBundle\Document\Areabrick;

use Pimcore\Model\Document\Tag\Area\Info;

class CustomWysiwyg extends AbstractAreabrick
{
    public function getName()
    {
        return 'Wysiwyg';
    }

    public function getDescription()
    {
        return 'Add a Wysiwyg Full Width block.';
    }

    public function getTemplateLocation()
    {
        return static::TEMPLATE_LOCATION_GLOBAL;
    }

    public function getHtmlTagOpen(Info $info)
    {

        if($info->index == 0) {
            return '<section><div class="container-fluid">';
        }

        return '<section class="mt-4"><div class="container-fluid">';
    }

    /**
     * {@inheritdoc}
     */
    public function getHtmlTagClose(Info $info)
    {
        return '</div></section>';
    }

}