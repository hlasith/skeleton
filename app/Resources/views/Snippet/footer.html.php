<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<footer>
    <div class="container-fluid px-0">
        <div class="row mx-0">
            <div class="col-12 d-flex flex-column align-items-center">
                <img width="120" src="/static/node_modules/ngl-ui-kit/ngl/images/ngl-logo.png" alt="NATIONAL GAMING LEAGUE Logo">
                <?php if ($this->editmode): ?>
                    <h2><?= $this->t('snippet.edit.footer.links.title', [], 'admin') ?></h2>
                    <?= $this->multihref('footer_links'); ?>
                <?php else: ?>
                <ul class="d-flex justify-content-between align-items-center">
                    <?php
                    /** @var \Pimcore\Model\Document\Page|\Pimcore\Model\Document\Link $element */
                    foreach ($this->multihref("footer_links") as $element):
                    ?>
                    <li>
                        <a class="text-uppercase ngl-link-primary"
                           href="<?=$element->getHref()?>">
                            <?php if(strlen($element->getProperty('navigation_name')) > 0): ?>
                                <?= $this->translate($element->getProperty('navigation_name')) ?>
                            <?php else: ?>
                                <?= $this->translate($element->getKey()) ?>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <?php if ($this->editmode): ?>
                <h2><?= $this->t('snippet.edit.footer.copyright.title', [], 'admin') ?></h2>
                <?php endif; ?>
                    <?= $this->wysiwyg('footer_copyright', ["toolbarGroups" => [
                        [
                            "name" => 'basicstyles',
                            "groups" => [ 'basicstyles', 'list', "links"]
                        ]
                    ]]) ?>
            </div>
        </div>
    </div>
</footer>

