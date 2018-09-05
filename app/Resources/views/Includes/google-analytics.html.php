<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
/** @var \Symfony\Component\HttpFoundation\Request $currentRequest */
$currentRequest = \Pimcore::getContainer()->get('request_stack')->getCurrentRequest();
if ( !$this->editmode
    && empty($currentRequest->get('pimcore_preview'))
    && (!$this->document->hasProperty('disable_googleAnalytics') || false == $this->document->getProperty('disable_googleAnalytics'))
) :
    if (\AppBundle\Tool\GoogleAnalytics::isEnabled()) : ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="<?= \AppBundle\Tool\GoogleAnalytics::getHostname(); ?>"></script>
        <script>

            require(['ngl', 'cms_tracking_manager'], function(NGL, TrackingManager){

                if(TrackingManager.isOptOut()) {
                    window['ga-disable-<?= \AppBundle\Tool\GoogleAnalytics::getSiteId() ?>'] = true;
                }

                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', '<?= \AppBundle\Tool\GoogleAnalytics::getSiteId() ?>');

            });

        </script><?php
    endif;
endif;?>
