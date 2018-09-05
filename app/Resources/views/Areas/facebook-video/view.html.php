<?php if ($this->editmode): ?>
    <div class="mb-4">
        <h2>Facebook-Video</h2>
        <div>
            URL: <?= $this->input("facebook_video_url"); ?>
        </div>
        <br/>
        <b>Advanced Configuration</b>
        <div>
            Width: <?= $this->numeric("iframe_width"); ?>px (default: 100%)
        </div>
        <div>
            Height: <?= $this->numeric("iframe_height"); ?>px (default: 450px)
        </div>
        <div>
            Transparent: <?= $this->checkbox("iframe_transparent"); ?> (default: false)
        </div>
    </div>
<?php else: ?>
    <?php if (!$this->input("facebook_video_url")->isEmpty()): ?>

        <?php
        // defaults
        $transparent = "false";
        $width       = "100%";
        $height      = "450";

        if (!$this->numeric("iframe_width")->isEmpty()) {
            $width = (string)$this->numeric("iframe_width");
        }
        if (!$this->numeric("iframe_height")->isEmpty()) {
            $height = (string)$this->numeric("iframe_height");
        }
        if ($this->checkbox("iframe_transparent")->isChecked()) {
            $transparent = "true";
        }
        ?>

        <style>
            .frameContainer { margin-bottom:6px; }
            .fIframe { width:100%; min-width:100%; border: 1px solid #0094ff;
                border-radius:3px;
                padding-top:6px;  }
        </style>
        <div class="frameContainer mt-4" style="min-width: 100%;">
            <iframe class="fIframe" frameborder="0" width="<?= $width; ?>" allowtransparency="<?=
            $transparent;
            ?>" scrolling="no" src="https://www.facebook.com/plugins/video.php?href=<?= urlencode($this->input("facebook_video_url")); ?>%2F&amp;show_text=0" style="border:none;overflow:hidden"></iframe>
        </div>

        <script>
            var fIframes = document.querySelectorAll('.fIframe');
            Array.prototype.forEach.call(fIframes, function(elements, index) {
                // conditional here.. access elements
                elements.setAttribute("height", ""+(elements.offsetWidth/1.5)+"px");
            });
        </script>
    <?php endif; ?>
<?php endif; ?>