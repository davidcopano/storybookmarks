<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TagController
 * @package MainBundle\Controller
 * @Route("tags")
 */
class TagController extends Controller
{
    /**
     * @Route("/", name="tags_list")
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        return new Response('<h1>tag</h1>');
    }

    /**
     * @Route("/new", name="tags_new")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        return new Response('<h1>tag - new</h1>');
    }

    /**
     * @Route("/edit", name="tags_edit")
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        return new Response('<h1>tag - edit</h1>');
    }

}