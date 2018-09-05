<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>



    <?= $this->renderlet("myGallery", [
        "controller" => "content",
        "action" => "gallery-renderlet",
         "title" => "Drag an asset folder here to get a gallery",
         "height" => 150
    ]); ?>


