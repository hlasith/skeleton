<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('layout.html.php');

?>


<?php $this->slots()->output('_content'); ?>

<?php // snippet to set up page configs for the cms web app ?>
<script>
    // activate frontpage parts
    var isFrontpage = true;
</script>
