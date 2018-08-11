<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Tag;
use MainBundle\Form\FolderType;
use MainBundle\Form\TagType;
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

        $tags = $this->getUser()->getTags();

        return $this->render('MainBundle:Tag:list.html.twig', ['tags' => $tags]);
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

        $tag = new Tag();
        $tag->setUser($this->getUser());

        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            $translator = $this->get('translator');
            $this->addFlash('success', $translator->trans('new_tag.success'));

            return $this->redirectToRoute('tags_list');
        }

        return $this->render('MainBundle:Tag:new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="tags_edit")
     * @param Request $request
     * @param Tag $tag
     * @return Response
     */
    public function editAction(Request $request, Tag $tag = null)
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('index', ['_locale' => $request->getLocale()]);
        }

        $translator = $this->get('translator');
        if(!$tag) {
            return $this->redirectToRoute('tags_list');
        }

        if($this->isOwnedTag($tag)) {
            $form = $this->createForm(TagType::class, $tag);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($tag);
                $em->flush();

                $translator = $this->get('translator');
                $this->addFlash('success', $translator->trans('new_tag.success'));

                return $this->redirectToRoute('tags_list');
            }

            return $this->render('MainBundle:Tag:edit.html.twig', ['form' => $form->createView(), 'tag' => $tag]);
        }
        else {
            return $this->redirectToRoute('tags_list');
        }
    }
    /**
     * @param Request $request
     * @param Tag $tag
     * @return Response
     * @Route("/delete/{id}", name="tags_delete")
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $translator = $this->get('translator');
        if(!$tag) {
            $this->addFlash('error', $translator->trans('public_bookmark.errors.not_found'));
            return $this->redirectToRoute('index');
        }

        if($this->isOwnedTag($tag)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();

            $this->addFlash('success', $translator->trans('bookmarks.deleted'));
            return $this->redirectToRoute('tags_list');
        }
        else {
            return $this->redirectToRoute('tags_list');
        }
    }

    private function isOwnedTag(Tag $tag)
    {
        foreach($this->getUser()->getTags() as $item) {
            if($item->getId() == $tag->getId()) {
                return true;
            }
        }
        return false;
    }
}
