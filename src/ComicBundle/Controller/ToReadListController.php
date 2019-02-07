<?php

namespace ComicBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ToReadListController extends Controller
{
    /**
     * @Route("/api/toreadlist", name="toReadList")
     * @return JsonResponse
     * @Method("GET")
     */
    public function listToReadListsAction()
    {
        $dq = $this->container->get('comic.manager.toreadlist')->listToReadList();

        return new JsonResponse($dq);

    }

}
