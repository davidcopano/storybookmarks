<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
