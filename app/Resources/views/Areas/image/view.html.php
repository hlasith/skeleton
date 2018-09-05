<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 * @var \Pimcore\Model\Document\Tag\Area\Info $info
 */
?>
<?php
$defaultConfig = ["thumbnail" => "content"];
$config = array_replace_recursive($defaultConfig, $info->getParams() ?? []);
?>
<section class="area-image">

    <?php if(!$this->editmode) { ?>
        <a href="<?= $this->image("image")->getThumbnail("galleryLightbox"); ?>" class="thumbnail">
    <?php } ?>

        <?= $this->image("image", $config); ?>

    <?php if(!$this->editmode) { ?>
        </a>
    <?php } ?>

</section>
