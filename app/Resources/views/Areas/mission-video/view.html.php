<?php

/**
 * @var \Pimcore\Templating\PhpEngine $this
 */

?>

<div class="row">
    <div class="col-12 px-0">
        <?php if($this->editmode): ?>
            <?= $this->video('mission_video', [
                "height" => 0
            ]) ?>
        <?php endif; ?>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?= $this->video('mission_video')->getYoutubeUrlEmbedded() ?>" allowfullscreen=""></iframe>
        </div>
    </div>
</div>