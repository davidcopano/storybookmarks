<?php

namespace MainBundle\Controller;

use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("{_locale}/", name="index", requirements={
        "_locale": "es|en"
*     })
     */
    public function indexAction()
    {
        return $this->render('@Main/Default/index.html.twig');
    }

    /**
     * @Route("{_locale}/send_form", name="index.send_form")
     * @param Request $request
     * @param Swift_Mailer $mailer
     * @return JsonResponse|Response
     */
    public function sendFormAction(Request $request, Swift_Mailer $mailer, LoggerInterface $logger)
    {
        $data = $request->request->all();

        if (isset($data['email']) && isset($data['subject']) && isset($data['description'])) {
            try {
                $message = (new Swift_Message('Contacto storybookmarks: ' . $data['subject']))
                    ->setFrom('info@storybookmarks.com')
                    ->setTo('davidcopano96@gmail.com')
                    ->setBody($this->renderView('Emails/web_contact.html.twig', [
                        'email' => $data['email'],
                        'subject' => $data['subject'],
                        'description' => $data['description']
                    ]), 'text/html');

                $mailer->send($message);

                return new JsonResponse(['type' => 'ok']);
            }
            catch (\Exception $exception) {
                $logger->error('[INDEX] Error al enviar formulario de contacto: ' . $exception->getMessage());
                return new JsonResponse(['type' => 'error']);
            }
        }
        else {
            $logger->error('[INDEX] No se han proporcionado suficientes datos para enviar el form. de contacto');
            return new JsonResponse(['type' => 'error']);
        }
    }

    /**
     * @Route("{_locale}/privacy-policy", name="index.privacy_policy")
     * @param Request $request
     * @return Response|null
     */
    public function privacyPolicyAction(Request $request)
    {
        return $this->render('@Main/Default/privacy_policy.html.twig');
    }
}
