<?php

/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
use Pimcore\Model\Document;
use Pimcore\Model\Asset;

?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" type="image/ico" href="/static/images/favicon.ico"><?php

/** @var Document|Page $document */
$document = $this->document;

// output the collected meta-data
// @todo WTF?!?!?!?!?!
if (!$document) {
    // use "home" document as default if no document is present
    $document = Document::getById(1);
    $this->document = $document;
}

// resolve links to their target
if ($document instanceof Document\Link) {
    $document = $document->getObject();
    $this->document = $document;
}

$this
    ->placeholder('meta')
    ->setIndent(0)
    ->set($this->template('Includes/meta.html.php', ['document' => $document]));

echo PHP_EOL . $this->placeholder('meta');

/* ---------- import fonts ---------- */
$this->headLink()
    ->appendStylesheet(\Pimcore::getContainer()->getParameter('fontUrlRoboto'))
    ->appendStylesheet(\Pimcore::getContainer()->getParameter('fontUrlTitilliumWeb'))
    ->appendStylesheet(\Pimcore::getContainer()->getParameter('fontUrlNglIconfont'))
    ->appendStylesheet(\Pimcore::getContainer()->getParameter('fontUrlFontAwesome'));

/* ---------- import stylesheet ---------- */
if ( $this->isPortal ) {
    $this->headLink()->appendStylesheet(\AppBundle\Tool\StaticAssets::getCssStylesPath());          // "new" css ui-kit/ngl
} else {
    $this->headLink()->appendStylesheet(\AppBundle\Tool\StaticAssets::getCssStylesContentPath());  // "old" css ui-kit/proclub/frontpage
}

/* ---------- stylesheet for backend ---------- */
if ($this->editmode) {
    $this->headLink()->appendStylesheet('/static/css/editmode.css', "screen");
}

/* ---------- output head ---------- */
echo PHP_EOL . $this->headLink(); //@todo avoid slash before the closing tag

/* if it is NOT the frontpage -> insert the font awsome svg solution "the new way" */
if ( ! $this->isPortal ) {
    $this->headScript()->appendFile('/static/fonts/font-awesome/fontawesome-all.min.js');
}

echo PHP_EOL . $this->headScript();