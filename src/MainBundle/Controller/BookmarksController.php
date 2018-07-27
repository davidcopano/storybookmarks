<?php

namespace MainBundle\Controller;

use Doctrine\Common\Util\Debug;
use MainBundle\Entity\Bookmark;
use MainBundle\Form\BookmarkType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        if (!$this->getUser()) {
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
        if (!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        $bookmark = new Bookmark();
        $bookmark->setUser($this->getUser());

        $form = $this->createForm(BookmarkType::class, $bookmark, ['data' =>
            ['tags' => $this->getUser()->getTags(), 'folders' => $this->getUser()->getFolders()],
            'data_class' => null
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // debido a que tenemos a null el 'data_class',
            // tenemos que rellenar los datos obtenidos a pelo en la nueva entidad
            $bookmark->setTitle($form->all()['title']->getData())
                    ->setUrl($form->all()['url']->getData())
                    ->setColor($form->all()['color']->getData())
                    ->setNote($form->all()['note']->getData())
                    ->setTag($form->all()['tag']->getData())
                    ->setFolder($form->all()['folder']->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($bookmark);
            $em->flush();

            $translator = $this->get('translator');
            $this->addFlash('success', $translator->trans('new_bookmark.success'));

            return $this->redirectToRoute('bookmarks_list');
        }

        return $this->render('MainBundle:Bookmarks:new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param Bookmark $bookmark
     * @return Response
     * @Route("/edit/{id}", name="bookmarks_edit")
     */
    public function editAction(Request $request, Bookmark $bookmark)
    {
        if (!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        return $this->render('MainBundle:Bookmarks:edit.html.twig', ['bookmark' => $bookmark]);
    }
}