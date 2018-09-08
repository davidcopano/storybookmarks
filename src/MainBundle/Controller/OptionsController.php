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

        $form = $this->createForm(OptionsType::class, $options);
        $form->handleRequest($request);

        return $this->render('MainBundle:Options:index.html.twig', ['form' => $form->createView(), 'options' => $options]);
    }

}
