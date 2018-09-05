<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 * @var \Pimcore\Model\Document\Tag\Area\Info $info
 */
?>
<?php
$defaultConfig = ["class" => "img-fluid"];
$config = array_replace_recursive($defaultConfig, $info->getParams() ?? []);
?>



<div class="ngl-mission-card ngl-light-bg row px-3 py-5">
    <div class="col-12 col-sm-6">
        <div class="<?php if (!$this->editmode): ?> d-flex <?php endif; ?> justify-content-center">
            <div>
                <?= $this->image('mission_left_image', $config); ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="<?php if (!$this->editmode): ?> d-flex <?php endif; ?> justify-content-center align-items-start flex-column h-100 py-3">
            <div class="w-100">
                <h1><?= $this->input('mission_text_headline'); ?></h1>
                <?= $this->wysiwyg('mission_text') ?>
            </div>
        </div>
    </div>
</div>