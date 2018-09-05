<?php

/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this
    ->placeholder('head')
    ->setIndent(8)
    ->set($this->template('Includes/head.html.php'));

$this
    ->placeholder('mainNavigation')
    ->setIndent(12)
    ->set($this->template('Includes/main-navigation.html.php'));

if ( $this->isPortal ) {

    $bodyId = 'ngl-pro';
    $bodyClass = 'ngl-pro-newhome';

} else {

    $bodyId = 'ngl-theme-view';
    $bodyClass = NULL;

}

if($this->isProClub) {
    $bodyClass = 'ngl-proclub-page';
}

?><!DOCTYPE html>
<html lang="<?= $this->getLocale() ?>">
    <head><?php

echo PHP_EOL . $this->placeholder('head');

?>

    </head>
    <body id="<?php echo $bodyId; ?>"<?php echo (NULL != $bodyClass ? ' class="' . $bodyClass . '"' : '') ?>>
        <header class="fixed-top"><?php

echo PHP_EOL . PHP_EOL . $this->placeholder('mainNavigation');

?>

        </header><?php
            $this->slots()->output('_content'); ?>

        <?php

if ($this->document->hasProperty('footer')) {
    $footer = $this->document->getProperty('footer');
    echo $this->inc($footer);
}
echo $this->template('Includes/js-body-end.html.php');
echo $this->template('Includes/piwik.html.php');
echo $this->template('Includes/google-analytics.html.php');

?>
    </body>
</html>
