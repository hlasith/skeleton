<?php

/**
 * @var \Pimcore\Templating\PhpEngine $this
 */

?>

<?php if($this->editmode): ?>
<div class="ngl-mission-card ngl-light-bg row px-3 py-5">
    <div class="col-12">
        <div class="text-center">
            <h1><?= $this->input('mission_registration_header'); ?></h1>
            <div class="mt-4">
                <button type="button" class="JS_cmsRegisterHandler ngl-btn-primary btn"><?= $this->input('mission_registration_button_text'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="ngl-mission-card ngl-light-bg row px-3 py-5">
    <div class="col-12">
        <div class="text-center">
            <h1><?= $this->input('mission_registration_loggedIn_header'); ?></h1>
            <div class="mt-4">
                <?= $this->wysiwyg('mission_registration_loggedIn_text'); ?>
            </div>
        </div>
    </div>
</div>
<?php else: ?>

<?php

    $isLoggedIn = strlen($_COOKIE['ngl_user']) > 10;

?>

<?php if(!$isLoggedIn): ?>
<div id="notLoggedInArea" class="ngl-mission-card ngl-light-bg row px-3 py-5">
    <div class="col-12">
        <div class="text-center">
            <h1><?= $this->input('mission_registration_header'); ?></h1>
            <div class="mt-4">
                <button type="button" class="JS_cmsRegisterHandler ngl-btn-primary btn"><?= $this->input('mission_registration_button_text'); ?></button>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div id="loggedInArea" class="ngl-mission-card ngl-light-bg row px-3 py-5">
    <div class="col-12">
        <div class="text-center">
            <h1><?= $this->input('mission_registration_loggedIn_header'); ?></h1>
            <div class="mt-4">
                <?= $this->wysiwyg('mission_registration_loggedIn_text'); ?>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            require(['jquery', 'js_cookie'], function($, Cookies){

                if(Cookies.get('ngl_user').length > 10) {
                    $('#notLoggedInArea').hide();
                    $('loggedInArea').show();
                }
            });
        });
    </script>
<?php endif; ?>

<?php endif; ?>
