<?php

namespace MainBundle\Controller;


use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
     * @return JsonResponse|Response
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
                            ->setParameter('user', $this->getUser())
                            ->setParameter('title', '%' . $query . '%')
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

        $jsonResults = [];

        if(count($bookmarks) > 0) {
            foreach($bookmarks as $bookmark) {
                $jsonResults['bookmarks'][] = [
                    'id' => $bookmark->getId(),
                    'title' => $bookmark->getTitle()
                ];
            }
        }
        else {
            $jsonResults['bookmarks'] = [];
        }

        if(count($folders) > 0) {
            foreach ($folders as $folder) {
                $jsonResults['folders'][] = [
                    'id' => $folder->getId(),
                    'name' => $folder->getName()
                ];
            }
        }
        else {
            $jsonResults['folders'] = [];
        }

        if(count($tags) > 0) {
            foreach($tags as $tag) {
                $jsonResults['tags'][] = [
                    'id' => $tag->getId(),
                    'title' => $tag->getTitle()
                ];
            }
        }
        else {
            $jsonResults['tags'] = [];
        }

        return new JsonResponse($jsonResults);
    }
}