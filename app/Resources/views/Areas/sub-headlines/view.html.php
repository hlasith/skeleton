<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 * @var \Pimcore\Model\Document\Tag\Area\Info $info
 */
?>
<div class="row ngl-edit-nav py-3">
    <div class="col-12">
        <h3 class="mb-0 mt-4"><?= $this->input("sub_headlines", $info->getParams() ?? []); ?></h3>
    </div>
</div>


