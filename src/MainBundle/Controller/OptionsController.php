<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BookmarksController
 * @package MainBundle\Controller
 * @Route("options")
 */
class OptionsController extends Controller
{
    /**
     * @param Request $request
     * @Route("/", name="options_index")
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('MainBundle:Options:index.html.twig');
    }
}