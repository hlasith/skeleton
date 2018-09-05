<?php

/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$mainNavStartNode = $document->getProperty('mainNavStartNode');

?>
<!-- Main Navigation --><?php

if ( $isPortal ) {

?>

<nav class="ngl-main-nav nav navbar navbar-expand-md pt-0">
    <div class="container-fluid d-flex justify-content-center align-items-end">
        <button class="navbar-toggler ngl-nav-toggler collapsed" type="button" data-toggle="collapse" data-target="#ngl-nav-responsive" aria-controls="ngl-nav-responsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars" aria-hidden="true"></i>
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
        <a class="ngl-logo navbar-brand mr-0" href="/"><img width="120" src="/static/node_modules/ngl-ui-kit/ngl/images/ngl-logo.png" alt="NATIONAL GAMING LEAGUE Logo"/></a>
        <div class="navbar-collapse collapse align-self-center align-self-lg-end pl-0 pl-md-4" id="ngl-nav-responsive"><?php

} else {

?>

<nav id="parenttest" class="ngl-main-nav navbar navbar-expand-md pt-0">
    <div class="container-fluid d-flex justify-content-center align-items-end">
        <button class="ngl-nav-toggler navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#ngl-nav-responsive" aria-controls="ngl-nav-responsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fal fa-bars"></i>
            <i class="fal fa-times"></i>
        </button>
        <a class="ngl-logo navbar-brand mr-0" href="/"><img width="120" src="/static/node_modules/ngl-ui-kit/ngl/images/ngl-logo.png" alt="NATIONAL GAMING LEAGUE Logo"/></a>
        <div class="navbar-collapse collapse align-self-center align-self-lg-end pl-0 pl-md-4" id="ngl-nav-responsive"><?php

}

$mainNavigation = $this->navigation()->buildNavigation($document, $mainNavStartNode);

/** @var \Pimcore\Navigation\Renderer\Menu $menuRenderer */
$menuRenderer = $this->navigation()->menu();

?>

            <ul class="nav navbar-nav justify-content-start mr-auto"><?php

foreach ($mainNavigation as $page) {

    /* @var $page \Pimcore\Navigation\Page\Document */
    // here need to manually check for ACL conditions

    if (!$page->isVisible() || !$menuRenderer->accept($page)) { continue; }
    $hasChildren = $page->hasPages();
    $isActive = $page->isActive();

?>

                <li class="nav-item">
                    <a class="nav-link text-uppercase<?php echo $isActive ? ' active' : ''; ?> <?= $page->getClass() ?>" href="<?=$page->getHref() ?>">
                        <?= $this->translate($page->getLabel()) ?>

                    </a>
                    <?php if(strpos(strtolower($page->getHref()),"proclub") != false): ?>
                    <ul class="ngl-sub-nav navbar-nav d-flex d-md-none flex-row">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $isProClubFrontpage ? 'active' : ''?>" href="/de_DE/Proclub">Start</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/proclub/league/ps4">Ligen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/proclub/cup/ps4">Pokale</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $isProClubRules ? 'active' : ''?>" href="Proclub/rules">Regeln</a>
                        </li>
                    </ul>
                    <?php endif; ?>
                </li><?php

}

?>

            </ul>
        </div><?php

if( $isPortal ){

?>

        <!-- signed in user profil -->
        <div class="JS_loggedIn" style="display: none;">
            <div class="ngl-signed-user CSSfixFrontpageUserMenu navbar-brand d-flex mr-0">
                <div>
                    <img width="45" class="img-fluid JS_userImage" src="">
                </div>
                <div class="ngl-card-userinfo d-none d-md-flex flex-column justify-content-center">
                    <h5 class="text-uppercase font-weight-bold mb-0 JS_userDisplayName"></h5>
                    <span class="JS_userFullname">&nbsp;</span>
                </div>
                <div class="ngl-dropdown">
                    <a class="ngl-link-primary pl-0" id="ngl-nav-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                    </a>
                    <div aria-labelledby="ngl-nav-toggle" class="dropdown-menu">
                        <a class="JS_cmsShowProfileHandler dropdown-item">Profil ansehen</a>
                        <a class="JS_cmsEditProfileHandler dropdown-item">Profil bearbeiten</a>
                        <a class="JS_logoutHandler dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- not signed in  -->
        <div class="JS_notLoggedIn ngl-login navbar-brand d-flex mr-0" style="display: none !important;">
            <a class="ngl-link-orange text-uppercase pl-0 JS_cmsLoginHandler" href="#">Anmelden</a>
        </div><?php

} else {

?>

        <!-- signed in user profil -->
        <div class="JS_loggedIn" style="display: none;">
            <div class="ngl-signed-user navbar-brand d-flex mr-0">
                <div>
                    <img width="45" class="img-fluid JS_userImage" src="">
                </div>
                <div class="ngl-card-userinfo d-none d-md-flex flex-column justify-content-center">
                    <h5 class="text-uppercase font-weight-bold mb-0 JS_userDisplayName"></h5>
                    <span class="JS_userFullname">&nbsp;</span>
                </div>
                <div class="ngl-dropdown">
                    <a class="ngl-link-primary pl-0" id="ngl-nav-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                        <i class="fal fa-angle-up ml-2" aria-hidden="true"></i>
                        <i class="fal fa-angle-down ml-2" aria-hidden="true"></i>
                    </a>
                    <div aria-labelledby="ngl-nav-toggle" class="dropdown-menu">
                        <a class="JS_cmsShowProfileHandler dropdown-item" href="#">Profil ansehen</a>
                        <a class="JS_cmsEditProfileHandler dropdown-item" href="#">Profil bearbeiten</a>
                        <a class="JS_logoutHandler dropdown-item" href="#">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- not signed in  -->
        <div class="JS_notLoggedIn ngl-login navbar-brand d-flex mr-0" style="display: none !important;">
            <a class="ngl-link-secondary text-uppercase pl-0 JS_cmsLoginHandler" href="#">Anmelden</a>
        </div><?php

}

?>

    </div>
</nav>
<!-- END Main Navigation -->

<?php

    if( $isProClub ):

?>
<!-- NGL PRO Sub Navigation -->
<nav class="ngl-sub-nav navbar navbar-expand-md py-4 px-0 d-none d-md-block pb-0">
    <div class="container-fluid px-0">
        <div class="collapse navbar-collapse" id="ngl-nav-responsive">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo $isProClubFrontpage ? 'active' : ''?>" href="/de_DE/Proclub"><i class="fal fa-futbol"></i>Start</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/proclub/league/ps4"><i class="fal fa-list-ol"></i>Ligen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/proclub/cup/ps4"><i class="fal fa-trophy"></i>Pokale</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $isProClubRules ? 'active' : ''?>" href="Proclub/rules"><i class="fal fa-university"></i>Regeln</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END NGL PRO Sub Navigation -->
<?php endif; ?>

<!-- BEGIN Cookie Notification -->
<div class="ngl-cookie-note fixed-bottom" style="display: none;">
    <div class="d-flex justify-content-end">
        <a class="ngl-icon-close pr-3 JS_COOKIE_DISMISS"><?php

            if( $isPortal ):

            ?>
                <i class="fa fa-times"></i>
            <?php else: ?>
                <i class="fal fa-times"></i>
            <?php endif; ?>
        </a>
    </div>
    <div class="ngl-grid-x2 d-flex align-items-center flex-column flex-md-row pt-0">
        <div class="pr-md-3">
            <p class="mb-md-0">Wir verwenden Cookies, um dir die optimale Nutzung der NGL.one zu garantieren. Was das genau bedeutet und welche Daten wir erheben, kannst du in unserer Datenschutzbestimmung erfahren.</p>
        </div>
        <div class="ngl-cookie-control d-flex justify-content-center align-items-center pl-md-3">
            <a class="ngl-link-primary mr-2" href="/de_DE/Datenschutz">Mehr informationen</a>
            <button type="button" class="ngl-btn-dark btn mx-2 JS_COOKIE_ACCEPT">Einverstanden</button>
        </div>
    </div>
</div>
<!-- END Cookie Notification -->
