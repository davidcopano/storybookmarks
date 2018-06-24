<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param Request $request
     * @param \Swift_Mailer $mailer
     */
    public function sendFormAction(Request $request, \Swift_Mailer $mailer)
    {
        // var_dump($_POST);die;

        $message = (new \Swift_Message('Hola_EDIT'))
                    ->setFrom('niidea@gmail.com')
                    ->setTo('davidcopano96@gmail.com')
                    ->setBody('Hola desde correo en PHP/Symfony');

        $numSent = $mailer->send($message);
        printf("Sent %d messages\n", $numSent);die;
    }
}
