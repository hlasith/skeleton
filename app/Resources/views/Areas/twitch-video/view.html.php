<?php if ($this->editmode): ?>
    <div>
        <h2>Twitch-Video</h2>
        <div>
            Channel source: <?= $this->input("twitch_channel_source"); ?>
        </div>
        <div>
            VOD/Stream source: <?= $this->input("twitch_video_source"); ?>
        </div>
        <div>
            Clip source: <?= $this->input("twitch_clip_source"); ?>
        </div>
        <div>
            Collection source: <?= $this->input("twitch_collection_source"); ?>
        </div>
        <br/>
        <b>Advanced Configuration</b>
        <div>
            Interactive (JS): <?= $this->checkbox("interactive"); ?>
        </div>
        <div>
            Width: <?= $this->numeric("iframe_width"); ?>px (default: 898)
        </div>
        <div>
            Transparent: <?= $this->checkbox("iframe_transparent"); ?> (default: false)
        </div>
    </div>
<?php else: ?>
    <?php if (!$this->input("twitch_video_source")->isEmpty()
        || !$this->input("twitch_channel_source")->isEmpty()
        || !$this->input("twitch_collection_source")->isEmpty()
        || !$this->input("twitch_clip_source")->isEmpty()): ?>

        <?php

        if($this->checkbox("interactive")->isChecked() && $this->input('twitch_clip_source')->isEmpty()) {

            // defaults
            $transparent = "false";
            $width       = "898";


            if (!$this->numeric("iframe_width")->isEmpty()) {
                $width = (string)$this->numeric("iframe_width");
            }
            if ($this->checkbox("iframe_transparent")->isChecked()) {
                $transparent = "true";
            }
        ?>
            <script src= "https://player.twitch.tv/js/embed/v1.js"></script>
            <div style="min-width:100%;" id="twitchPlayer"></div>
            <script type="text/javascript">
              var options = {
                origin: <?php echo 'https://' . $_SERVER['HTTP_HOST'] ?>,
                width: document.getElementById('twitchPlayer').offsetWidth,
                <?php if(!$this->input('twitch_channel_source')->isEmpty()): ?> channel: "<?= $this->input("twitch_channel_source"); ?>",<?php endif;?>
                <?php if(!$this->input('twitch_video_source')->isEmpty()): ?> video: "<?= $this->input("twitch_video_source"); ?>",<?php endif;?>
                <?php if(!$this->input('twitch_collection_source')->isEmpty()): ?>collection: "<?= $this->input("twitch_collection_source"); ?>",<?php endif;?>
              };
              var player = new Twitch.Player("twitchPlayer", options);
              player.setVolume(0.5);
            </script>

        <?php

        } else {

            // defaults
            $transparent = "false";
            $width       = "898";


            if (!$this->numeric("iframe_width")->isEmpty()) {
                $width = (string)$this->numeric("iframe_width");
            }
            if ($this->checkbox("iframe_transparent")->isChecked()) {
                $transparent = "true";
            }?>

            <iframe
                    style="min-width: 100%"
                    class="twitchIframe"
            <?php if($this->input('twitch_clip_source')->isEmpty()): ?>
                    src="https://player.twitch.tv/?origin=<?php echo 'https://' . $_SERVER['HTTP_HOST'] ?>&channel=<?php if(!$this->input('twitch_channel_source')->isEmpty()) { echo $this->input("twitch_channel_source"); } ?>&video=<?php if(!$this->input('twitch_video_source')->isEmpty()) { echo $this->input("twitch_video_source"); } ?>&collection=<?php if(!$this->input('twitch_collection_source')->isEmpty()) {echo $this->input("twitch_collection_source"); } ?>"
            <?php else: ?>
                    src="https://clips.twitch.tv/embed?origin=<?php echo 'https://' . $_SERVER['HTTP_HOST'] ?>&clip=<?= $this->input('twitch_clip_source'); ?>"
            <?php endif; ?>
                    frameborder="no"
                    scrolling="no"
                    allowfullscreen="true">
            </iframe>

            <script>
                var elements = document.getElementsByClassName('twitchIframe');
                for(var i = 0; i < elements.length; i++) {
                    var element = elements[i];
                    element.setAttribute("height", ""+(element.offsetWidth/1.5)+"px");
                }
            </script>
 <?php
        }

?>

    <?php endif; ?>
<?php endif; ?>
