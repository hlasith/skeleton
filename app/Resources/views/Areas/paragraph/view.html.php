<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 * @var \Pimcore\Model\Document\Tag\Area\Info $info
 */
?>
<?php
    $defaultConfig = [
        "height" => 200,
        "toolbarGroups" => [
            [
                "name" => 'basicstyles',
                "groups" => [ 'basicstyles', 'list', "links"]
            ]
        ]
    ];

    $config = array_merge_recursive($defaultConfig, $info->getParams() ?? []);

?>
<?= $this->wysiwyg("paragraph",  $config); ?>