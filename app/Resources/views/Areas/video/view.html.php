<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 * @var \Pimcore\Model\Document\Tag\Area\Info $info
 */
?>

<?php
$defaultConfig = [
    "attributes" => [
        "class" => "video-js vjs-default-skin vjs-big-play-centered",
        "data-setup" => "{}"
    ],
    "thumbnail" => "content",
    "height" => 380
];
$config = array_replace_recursive($defaultConfig, $info->getParams() ?? []);
?>

<?php if($this->editmode): ?>
    <section class="area-video">
        <?= $this->video("video", $config); ?>
    </section>
<?php elseif($this->video('video')->getVideoType() == "youtube"): ?>
    <section class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="<?= $this->video('video')->getYoutubeUrlEmbedded() ?>" allowfullscreen=""></iframe>
    </section>
<?php else: ?>
    <section class="area-video">
        <?= $this->video("video", $config); ?>
    </section>
<?php endif; ?>