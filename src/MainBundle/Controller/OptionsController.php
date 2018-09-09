<?php

namespace MainBundle\Controller;

use Doctrine\Common\Util\Debug;
use MainBundle\Entity\Options;
use MainBundle\Form\OptionsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OptionsController
 * @package MainBundle\Controller
 * @Route("options")
 */
class OptionsController extends Controller
{
    /**
     * @Route("/", name="options_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $options = $this->getUser()->getOptions();
        if(!$options) {
            $options = new Options();
            $this->getUser()->setOptions($options);
        }

        $form = $this->createForm(OptionsType::class, $options, ['data' => ['options' => $options], 'data_class' => null]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $multimediaEnabled = $form->all()['multimediaEnabled']->getData();
            $options->setMultimediaEnabled($multimediaEnabled);

            $this->getUser()->setOptions($options);

            $em = $this->getDoctrine()->getManager();
            $em->persist($options);
            $em->persist($this->getUser());

            $em->flush();

            $translator = $this->get('translator');
            $this->addFlash('success', $translator->trans('options.success.text'));
        }

        return $this->render('MainBundle:Options:index.html.twig', ['form' => $form->createView(), 'options' => $options]);
    }

}
