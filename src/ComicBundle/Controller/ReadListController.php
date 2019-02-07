<?php

namespace ComicBundle\Controller;

use ComicBundle\Entity\ReadList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReadListController extends Controller
{
    /**
     * @Route("/api/readlist", name="readlist")
     * @param Request $request
     * @return JsonResponse
     * @Method("GET")
     */
    public function listReadListsAction(Request $request)
    {
        $readListRepository=$this->getDoctrine()->getManager()->getRepository(ReadList::class);
        $readLists=$readListRepository->listReadLists($request->query->all());

        return new JsonResponse($readLists);

    }

}
