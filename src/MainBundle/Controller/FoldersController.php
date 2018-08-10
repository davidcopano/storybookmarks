<?php

namespace MainBundle\Controller;

use Doctrine\Common\Util\Debug;
use MainBundle\Entity\Folder;
use MainBundle\Form\FolderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BookmarksController
 * @package MainBundle\Controller
 * @Route("folders")
 */
class FoldersController extends Controller
{
    /**
     * @param Request $request
     * @Route("/", name="folders_list")
     * @return Response
     */
    public function listAction(Request $request)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        $folders = $this->getUser()->getFolders();

        return $this->render('MainBundle:Folders:list.html.twig', ['folders' => $folders]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="folders_new")
     */
    public function newAction(Request $request)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        $folder = new Folder();
        $folder->setUser($this->getUser());

        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($folder);
            $em->flush();

            $translator = $this->get('translator');
            $this->addFlash('success', $translator->trans('new_folder.success'));

            return $this->redirectToRoute('folders_list');
        }

        return $this->render('MainBundle:Folders:new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @return Response
     * @param Folder $folder
     * @Route("/edit/{id}", name="folders_edit")
     */
    public function editAction(Request $request, Folder $folder = null)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        $translator = $this->get('translator');
        if(!$folder) {
            $this->addFlash('error', $translator->trans('public_bookmark.errors.not_found'));
            return $this->redirectToRoute('bookmarks_list');
        }

        if($this->isOwnedFolder($folder)) {
            $form = $this->createForm(FolderType::class, $folder);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($folder);
                $em->flush();

                $translator = $this->get('translator');
                $this->addFlash('success', $translator->trans('new_folder.success'));

                return $this->redirectToRoute('folders_list');
            }

            return $this->render('@Main/Folders/edit.html.twig', ['form' => $form->createView(), 'folder' => $folder]);
        }
        else {
            return $this->redirectToRoute('folders_list');
        }
    }

    private function isOwnedFolder(Folder $folder)
    {
        foreach($this->getUser()->getFolders() as $item) {
            if($item->getId() == $folder->getId()) {
                return true;
            }
        }
        return false;
    }
}