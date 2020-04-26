<?php

namespace MainBundle\Controller;


use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
        $defaultData = ['enable_multimedia' => $this->getUser()->getEnableMultimedia()];
        $form = $this->createFormBuilder($defaultData)
                    ->add('enable_multimedia', CheckboxType::class, ['required' => false])
                    ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->getUser()->setEnableMultimedia($data['enable_multimedia']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($this->getUser());
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('options.success.text'));
        }

        return $this->render('MainBundle:Options:index.html.twig', ['form' => $form->createView()]);
    }
}