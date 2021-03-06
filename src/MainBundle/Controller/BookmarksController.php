<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Bookmark;
use MainBundle\Form\BookmarkType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
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

        $orderBy = $request->query->get('order_by');
        $bookmarks = null;

        if(isset($orderBy)) {
            if($orderBy === 'default') {
                $bookmarks = $this->getDoctrine()->getRepository('MainBundle:Bookmark')->findBy(['user' => $this->getUser()], ['createdAt' => 'DESC']);
            }
            else if($orderBy === 'oldest_to_lowest') {
                $bookmarks = $this->getDoctrine()->getRepository('MainBundle:Bookmark')->findBy(['user' => $this->getUser()], ['createdAt' => 'ASC']);
            }
            else if($orderBy === 'a_to_z') {
                $bookmarks = $this->getDoctrine()->getRepository('MainBundle:Bookmark')->findBy(['user' => $this->getUser()], ['title' => 'ASC']);
            }
            else if($orderBy === 'z_to_a') {
                $bookmarks = $this->getDoctrine()->getRepository('MainBundle:Bookmark')->findBy(['user' => $this->getUser()], ['title' => 'DESC']);
            }
        }
        else {
            $bookmarks = $this->getDoctrine()->getRepository('MainBundle:Bookmark')->findBy(['user' => $this->getUser()], ['createdAt' => 'DESC']);
        }

        $page = $request->query->get('page') ? $request->query->get('page') : 1;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($bookmarks, $page, 10);

        return $this->render('MainBundle:Bookmarks:list.html.twig', ['bookmarks' => $bookmarks, 'pagination' => $pagination]);
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
                    ->setPublic($form->all()['public']->getData())
                    ->setExpirationDate($bookmark->isPublic() ? $form->all()['expirationDate']->getData() : null)
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
    public function editAction(Request $request, Bookmark $bookmark = null)
    {
        if (!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        $translator = $this->get('translator');
        if(!$bookmark) {
            $this->addFlash('error', $translator->trans('public_bookmark.errors.not_found'));
            return $this->redirectToRoute('bookmarks_list');
        }

        if($this->isOwnedBookmark($bookmark)) {
            $form = $this->createForm(BookmarkType::class, $bookmark, ['data' =>
                ['tags' => $this->getUser()->getTags(), 'folders' => $this->getUser()->getFolders()],
                'data_class' => null
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // debido a que tenemos a null el 'data_class',
                // tenemos que rellenar los datos obtenidos a pelo en la entidad
                $bookmark->setTitle($form->all()['title']->getData())
                    ->setUrl($form->all()['url']->getData())
                    ->setColor($form->all()['color']->getData())
                    ->setNote($form->all()['note']->getData())
                    ->setTag($form->all()['tag']->getData())
                    ->setPublic($form->all()['public']->getData())
                    ->setExpirationDate($bookmark->isPublic() ? $form->all()['expirationDate']->getData() : null)
                    ->setFolder($form->all()['folder']->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($bookmark);
                $em->flush();

                $translator = $this->get('translator');
                $this->addFlash('success', $translator->trans('new_bookmark.success'));

                return $this->redirectToRoute('bookmarks_list');
            }

            return $this->render('@Main/Bookmarks/edit.html.twig', ['form' => $form->createView(), 'bookmark' => $bookmark]);
        }
        else {
            return $this->redirectToRoute('bookmarks_list');
        }
    }

    /**
     * @param Request $request
     * @param Bookmark $bookmark
     * @return Response
     * @Route("/delete/{id}", name="bookmarks_delete")
     */
    public function deleteAction(Request $request, Bookmark $bookmark = null)
    {
        $translator = $this->get('translator');
        if(!$bookmark) {
            $this->addFlash('error', $translator->trans('public_bookmark.errors.not_found'));
            return $this->redirectToRoute('index');
        }

        if($this->isOwnedBookmark($bookmark)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bookmark);
            $em->flush();

            $this->addFlash('success', $translator->trans('bookmarks.deleted'));
            return $this->redirectToRoute('bookmarks_list');
        }
        else {
            return $this->redirectToRoute('bookmarks_list');
        }
    }

    /**
     * @param Request $request
     * @param Bookmark $bookmark
     * @Route("/public/{id}", name="bookmarks_public")
     * @return Response
     */
    public function showPublicAction(Request $request, Bookmark $bookmark = null)
    {
        $translator = $this->get('translator');
        if(!$bookmark) {
            $this->addFlash('error', $translator->trans('public_bookmark.errors.not_found'));
            return $this->redirectToRoute('index');
        }

        if($bookmark->checkValidPublic()) {
            return $this->render('MainBundle:Bookmarks/Public:show.html.twig', ['bookmark' => $bookmark]);
        }
        else {
            $this->addFlash('error', $translator->trans('public_bookmark.errors.not_found'));
            return $this->redirectToRoute('index');
        }
    }

    /**
     * @param Request $request
     * @Route("/download", name="bookmarks_download")
     * @return Response
     */
    public function downloadAction(Request $request)
    {
        $bookmarks = $this->getUser()->getBookmarks();
        return $this->render('@Main/Bookmarks/download.html.twig', ['bookmarks' => $bookmarks]);
    }

    private function isOwnedBookmark(Bookmark $bookmark)
    {
        foreach($this->getUser()->getBookmarks() as $item) {
            if($item->getId() == $bookmark->getId()) {
                return true;
            }
        }
        return false;
    }
}