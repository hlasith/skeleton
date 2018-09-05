<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
foreach (\AppBundle\Tool\StaticAssets::getJsPaths() as $path) {
    $this->inlineScript()->appendFile($path);
}




$this->inlineScript()->appendScript(
    'require(["ngl"], function(Ngl){Ngl.initialize({
           
        });});');


echo PHP_EOL . $this->inlineScript();

