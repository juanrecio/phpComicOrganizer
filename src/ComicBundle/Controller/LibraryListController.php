<?php

namespace ComicBundle\Controller;



use ComicBundle\Entity\LibraryList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LibraryListController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/api/librarylist", name="librarylist")
     * @param Request $request
     * @return JsonResponse
     * @Method("GET")
     */
    public function listLibraryListsAction(Request $request)
    {
        $libraryListRepository=$this->getDoctrine()->getManager()->getRepository(LibraryList::class);
        $libraryLists=$libraryListRepository->listLibraryLists($request->query->all());

        return new JsonResponse($libraryLists);

    }




}
