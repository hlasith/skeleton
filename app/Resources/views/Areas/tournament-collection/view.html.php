<?php

/**
 * @var \Pimcore\Templating\PhpEngine $this
 */

?>

<?php if ($this->editmode): ?>
    <div class="ngl-headline-big col-12 pb-5 pt-2 px-3">
        <h1 class="text-uppercase mb-0 pl-0 pl-lg-3 h1">
            <?= $this->input('tournament_collection__subheadline'); ?>
        </h1>
        <h5 class="text-uppercase pl-0 pl-lg-3">
            <?= $this->input('tournament_collection__description'); ?>
        </h5>
    </div>
<?php elseif (!$this->input('tournament_collection__subheadline')->isEmpty()): ?>
    <div class="ngl-headline-big col-12 pb-5 pt-2 px-3">
        <h1 class="text-uppercase mb-0 pl-0 pl-lg-3 h1">
            <?= $this->input('tournament_collection__subheadline'); ?>
        </h1>
<?php if (!$this->input('tournament_collection__description')->isEmpty()): ?>
        <h5 class="text-uppercase pl-0 pl-lg-3">
            <?= $this->input('tournament_collection__description'); ?>
        </h5>
<?php endif; ?>
    </div>
<?php endif; ?>


    <?php
    $block = $this->block("tournamentCollectionBlock");
    $htmlBlock = "";
    while ($block->loop()) : ?>
    <?php if ($this->editmode): ?>
        <?= $this->href("tournament", [
            "width" => 400,
            "types" => ["document", "object"],
            "subtypes" => [
                "document" => ["page"],
                "object" => ["object"]
            ]
        ]);
        ?>
    <?php endif; ?>

        <?php
        if ( !$this->href("tournament")->isEmpty()):
        $t = $this->href("tournament")->getElement();


        if (($t instanceof \Pimcore\Model\Document\Page && $t->getController() == '@AppBundle\Controller\TournamentController' && $t->getAction() == 'detail')) {
            $t = $t->getProperty("tournament");
        }

        if ($t instanceof \Pimcore\Model\DataObject\Tournament):

        $htmlBlock .= '<div style="max-width: 320px;" class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4 px-2">'. PHP_EOL .
            $this->template('Includes/tournament_flip_card.html.php', ['tournament' => $t, 'nglContentTheme' => true]) . PHP_EOL .
            '</div>'
        ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endwhile; ?>

<div class="ngl-grid ngl-light-bg <?php if ($this->input('tournament_collection__subheadline')->isEmpty()): ?> mt-4 <?php
endif; ?>" id="moreTournamentCollapse">
    <div class="ngl-grid  d-flex  flex-wrap  justify-content-around ">
<?php echo $htmlBlock; ?>
    </div>
</div>





