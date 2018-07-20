<?php

namespace MainBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BookmarksController
 * @package MainBundle\Controller
 * @Route("bookmarks")
 */
class BookmarksController extends Controller
{
    /**
     * @param Request $request
     * @Route("/", name="bookmarks_list")
     * @return Response
     */
    public function listAction(Request $request)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        $bookmarks = $this->getUser()->getBookmarks();

        return $this->render('MainBundle:Bookmarks:list.html.twig', ['bookmarks' => $bookmarks]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="bookmarks_new")
     */
    public function newAction(Request $request)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        return $this->render('MainBundle:Bookmarks:new.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/edit", name="bookmarks_edit")
     */
    public function editAction(Request $request)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        return new Response('<h1>bookmarks - edit</h1>');
    }
}