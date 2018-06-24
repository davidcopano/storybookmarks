<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class IndexController extends Controller
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

    /**
     * @Route("{_locale}/send_form", name="index.send_form")
     */
    public function sendFormAction(Request $request)
    {
//        $data = json_decode(file_get_contents("php://input"), TRUE);
//        var_dump($data);die;

        var_dump($_POST);die;
    }
}
