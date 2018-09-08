<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class OptionsController
 * @package MainBundle\Controller
 * @Route("options")
 */
class OptionsController extends Controller
{
    /**
     * @Route("/", name="options_index")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:Options:index.html.twig', array(
            // ...
        ));
    }

}
