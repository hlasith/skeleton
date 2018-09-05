<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<section class="area-featurette area-featurette ngl-section-dark pt-5">
    <?php while($this->block("block")->loop()) { ?>
    <div class="container p-3">
        <div class="row">

            <?php
                $position = $this->select("position")->getData();
                if(!$position) {
                    $position = "right";
                }
            ?>
            <div class="col-12 <?= ($position == "right") ? "col-sm-6 push-sm-6" : "col-sm-6"; ?>">
                <?php if($this->editmode) { ?>
                    <div class="editmode-label">
                        <label>Orientation:</label>
                        <?= $this->select("position", ["store" => [["left","left"],["right","right"]]]); ?>
                    </div>
                    <div class="editmode-label">
                        <label>Type:</label>
                        <?= $this->select("type", ["reload" => true, "store" => [["video","video"], ["image","image"]]]); ?>
                    </div>
                <?php } ?>

                <?php
                $type = $this->select("type")->getData();
                if($type == "video") {
                    echo $this->video("video", [
                        "thumbnail" => "featurerette",
                        "attributes" => [
                            "class" => "video-js vjs-default-skin vjs-big-play-centered",
                            "data-setup" => "{}"
                        ],
                    ]);
                } else {
                   
                    $imgConfig = [
                        "class" => "d-block w-100",
                        "thumbnail" => "featurerette"
                    ];

                    echo $this->image("image", $imgConfig);
                }
                ?>
            </div>
            <div class="col-12  <?= ($position == "right") ? "col-sm-6 pull-sm-6" : "col-sm-6"; ?>">
                <h5 class="border-top ngl-border-secondary  py-3">
                    <?= $this->input("headline"); ?>
                    <span class="text-muted"><?= $this->input("subline"); ?></span>
                </h5>
                <div>
                    <?= $this->wysiwyg("content", ["height" => 200]); ?>
                </div>
            </div>

        </div>
    </div>

        <?php if($this->block("block")->getCurrent() < $this->block("block")->getCount()-1) { ?>
            <hr class="featurette-divider">
        <?php } ?>
    <?php } ?>
</section>


