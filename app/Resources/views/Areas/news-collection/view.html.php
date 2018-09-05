<?php

/**
 * @var \Pimcore\Templating\PhpEngine $this
 */

?>
<?php if ($this->editmode): ?>
    <div class="ngl-headline-big col-12 pb-5 pt-2 px-3">
        <h1 class="text-uppercase mb-0 pl-0 pl-lg-3 h1">
            <?= $this->input('news_collection__subheadline'); ?>
        </h1>
        <h5 class="text-uppercase pl-0 pl-lg-3">
            <?= $this->input('news_collection__description'); ?>
        </h5>
    </div>
<?php elseif (!$this->input('news_collection__subheadline')->isEmpty()): ?>
    <div class="ngl-headline-big col-12 pb-5 pt-2 px-3">
        <h1 class="text-uppercase mb-0 pl-0 pl-lg-3 h1">
            <?= $this->input('news_collection__subheadline'); ?>
        </h1>
        <?php if (!$this->input('news_collection__description')->isEmpty()): ?>
        <h5 class="text-uppercase pl-0 pl-lg-3">
            <?= $this->input('news_collection__description'); ?>
        </h5>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if (!$this->editmode): ?>
<div class="ngl-grid ngl-light-bg <?php if ($this->input('news_collection__subheadline')->isEmpty()): ?> mt-4 <?php
endif; ?> justify-content-center row ml-0 mr-0"><?php endif; ?>

    <?php
    $block = $this->block("contentblock");
    while ($block->loop()) : ?>
    <?php if ($this->editmode): ?>

        <?= $this->href("pinnedNews", ["width" => 700, "class" => "pull-left"]); ?>
        <div class="clearfix"></div>
    <?php endif;

    if (!$this->href("pinnedNews")->isEmpty()):
    ?>
    <?php if ($this->editmode): ?>
    <div class="ngl-grid ngl-light-bg mt-4  justify-content-center row ml-0 mr-0"><?php endif; ?>

        <?php
        $news = $this->href("pinnedNews")->getElement();
        echo '<div class="col-12 col-xl-10 d-flex justify-content-center">';
        echo $this->template('Includes/news-card-list-item.html.php', ['news' => $news]);
        echo '</div>';
        ?>
        <?php endif; ?>
        <?php endwhile; ?>
    </div>

