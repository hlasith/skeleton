<?php

use Pimcore\Model\Document;

$document = $this->document;

if ($document instanceof Document\Page) {
    if ($document->getTitle()) {
        $this->headTitle()->set($document->getTitle());
        $this->headTitle()->setSeparator(' : ')->append("National Gaming League");
        echo PHP_EOL . $this->headTitle();
        $titleText = $document->getTitle() . " : National Gaming League";
        $this->headMeta()->setProperty('og:title', $titleText);
        $this->headMeta()->addRaw('<meta itemprop="name" value="'. $titleText .'">');
        $this->headMeta()->addRaw('<meta name="twitter:title" value="'. $titleText .'">');
    }
    if ($document->getDescription()) {
        $this->headMeta()->setDescription($document->getDescription());
        $this->headMeta()->setProperty('og:description', $document->getDescription());
        $this->headMeta()->addRaw('<meta itemprop="description" value="'. $document->getDescription() .'">');
        $this->headMeta()->addRaw('<meta name="twitter:description" value="'. $document->getDescription() .'">');
    }
}
$this->headMeta()->setProperty('og:url', \Pimcore\Tool::getHostUrl() . $document->getFullPath());
$this->headMeta()->setProperty('article:modified_time', date('c', $document->getModificationDate()));

// setting content type and character set
$this->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
    ->appendHttpEquiv('Content-Language', 'de-DE');
if ($document instanceof Document\Page) {
    // check for a news document
    if (\AppBundle\Tool\NewsUtil::isNewsPage($document)) {
        if(!$this->datetime('news_published_date')->isEmpty()) {
            $this->headMeta()->setProperty('article:published_time', date('c', $this->datetime('news_published_date')->getData()->getTimestamp()));
        }
        $this->headMeta()->setProperty('og:type', 'article');
        if (!$this->image('news_image')->isEmpty()) {
            $this->headMeta()->addRaw('<meta itemprop="image" content="'. \Pimcore\Tool::getHostUrl() . $this->image('news_image')->getSrc() .'">');
            $this->headMeta()->addRaw('<meta name="twitter:image:src" content="'. \Pimcore\Tool::getHostUrl() . $this->image('news_image')->getSrc() .'">');
            $this->headMeta()->addRaw('<meta property="og:image" content="'. \Pimcore\Tool::getHostUrl() . $this->image('news_image')->getSrc() .'">');
            $this->headMeta()->addRaw('<meta property="article:section" content="News">');
        }
    } else {
        $this->headMeta()->setProperty('article:published_time', date('c', $document->getCreationDate()));
        $this->headMeta()->addRaw('<meta itemprop="image" content="'. \Pimcore\Tool::getHostUrl() .'/static/images/NGL_meta.jpg">');
        $this->headMeta()->addRaw('<meta name="twitter:image" content="'. \Pimcore\Tool::getHostUrl() .'/static/images/NGL_meta.jpg">');
        $this->headMeta()->addRaw('<meta property="og:image" content="'. \Pimcore\Tool::getHostUrl() .'/static/images/NGL_meta.jpg">');
    }
    // get tags from documents
    $tagsMeta = "";
    $tags = \Pimcore\Model\Element\Tag::getTagsForElement('document', $document->getId());
    if (!empty($tags)) {
        foreach ($tags as $index => $tag) :
            $tagsMeta .= $this->translate($tag->getName()) . " ";
        endforeach;
    }
} else {
    $this->headMeta()->setProperty('og:type', 'website');
}

$this->headMeta()->addRaw('<meta property="og:site_name" content="National Gaming League">');
$this->headMeta()->addRaw('<meta name="twitter:card" content="summary_large_image">');
$this->headMeta()->addRaw('<meta name="twitter:site" content="@NGL_eSport">');

if ($this->headMeta()->count()) {
    echo PHP_EOL . $this->headMeta();
} ?>
