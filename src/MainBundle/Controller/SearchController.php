<?php

namespace MainBundle\Controller;


use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchController
 * @package MainBundle\Controller
 * @Route("search")
 */
class SearchController extends Controller
{
    /**
     * @Route("/", name="search_index")
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        $query = $request->query->get('query');
        if(!isset($query)) {
            return new JsonResponse(['type' => 'error', 'message' => 'La consulta no puede estar vacía']);
        }
        if(!$this->getUser()) {
            return new JsonResponse(['type' => 'error', 'message' => 'No se ha encontrado usuario logeado']);
        }

        $bookmarks = $this->getDoctrine()
                            ->getRepository('MainBundle:Bookmark')
                            ->createQueryBuilder('b')
                            ->where('b.user = :user')
                            ->andWhere('b.title LIKE :title')
                            ->orWhere('b.note LIKE :note')
                            ->setParameter('user', $this->getUser())
                            ->setParameter('title', '%' . $query . '%')
                            ->setParameter('note', '%' . $query . '%')
                            ->getQuery()
                            ->getResult();

        $folders = $this->getDoctrine()
                    ->getRepository('MainBundle:Folder')
                    ->createQueryBuilder('f')
                    ->where('f.user = :user')
                    ->andWhere('f.name LIKE :name')
                    ->setParameter('user', $this->getUser())
                    ->setParameter('name', '%' . $query . '%')
                    ->getQuery()
                    ->getResult();

        $tags = $this->getDoctrine()
                    ->getRepository('MainBundle:Tag')
                    ->createQueryBuilder('t')
                    ->where('t.user = :user')
                    ->andWhere('t.title LIKE :title')
                    ->setParameter('user', $this->getUser())
                    ->setParameter('title', '%' . $query . '%')
                    ->getQuery()
                    ->getResult();

        Debug::dump($bookmarks);die;
    }
}