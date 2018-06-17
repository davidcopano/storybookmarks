<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="root")
     */
    public function rootAction()
    {
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("{_locale}/", name="index")
     */
    public function indexAction()
    {
        return $this->render('@Main/Default/index.html.twig');
    }
}
