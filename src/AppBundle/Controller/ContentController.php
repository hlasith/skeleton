<?php

namespace AppBundle\Controller;

/**
 * Please Keep
 * use Pimcore\Controller\Configuration\ResponseHeader;
 */

use Pimcore\Controller\FrontendController;
use Pimcore\Log\ApplicationLogger;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Paginator\Paginator;

class ContentController extends FrontendController
{

    /**
     * @var ApplicationLogger
     */
    private $logger;

    /**
     * ContentController constructor.
     * @param ApplicationLogger $logger
     */
    public function __construct( ApplicationLogger $logger )
    {
        $this->logger = $logger;
    }

    public function defaultAction()
    {
        $gameList = new GameListing();
        $this->view->gameList = $gameList;
    }

    /**
     * The annotations below demonstrate the ResponseHeader annotation which can be
     * used to set custom response headers on the auto-rendered response. At this point, the headers
     * are not really set as we don't have a response yet, but they will be added to the final response
     * by the ResponseHeaderListener.
     *
     * @    //ResponseHeader("X-Custom-Header", values={"Foo", "Bar"})
     * @    //ResponseHeader("X-Custom-Header2", values="Bazinga", replace=true)
     */
    public function portalAction(Request $request)
    {

       
        $this->view->isPortal = true;

     

    }

   

}
