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
    && (!$this->document->hasProperty('disable_piwik') || false == $this->document->getProperty('disable_piwik'))
) :
    if (\AppBundle\Tool\Piwik::isEnabled()) : ?>

<script type="text/javascript">

    require(['ngl', 'cms_tracking_manager'], function(NGL, TrackingManager){
        if(!TrackingManager.isOptOut()) {
            var _paq = _paq || [];
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function () {
                var u = "//<?= \AppBundle\Tool\Piwik::getHostname(); ?>/";
                _paq.push(['setTrackerUrl', u + 'piwik.php']);
                _paq.push(['setSiteId', '<?= \AppBundle\Tool\Piwik::getSiteId(); ?>']);
                var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
                g.type = 'text/javascript';
                g.async = true;
                g.defer = true;
                g.src = u + '<?= \AppBundle\Tool\Piwik::getJsFilePath(); ?>';
                s.parentNode.insertBefore(g, s);
            })();
        }
    });


</script><?php
    endif;
endif;?>
