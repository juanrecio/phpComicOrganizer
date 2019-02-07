<?php

namespace ComicBundle\Controller;

use ComicBundle\Entity\Comic;
use ComicBundle\Form\ComicType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ComicController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/api/comic", name="create_comic")
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Method("POST")
     */
    public function createAction(Request $request)
    {

        $comic = new Comic();
        $response = new JsonResponse();
        $form = $this->createForm(ComicType::class, $comic);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $comic = $this->container->get('comic.manager.comic')->create($comic);
            $response->setContent(
                json_encode(
                    [
                        'id' => $comic->getId(),
                    ]
                )
            );
            $response->setStatusCode(JsonResponse::HTTP_CREATED);
        } else {
            $response->setContent(
                json_encode(
                    [
                        'error' => 'Invalid data',
                    ]
                )
            );
            $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);;
        }

        return $response;


    }

    /**
     * @Route("/api/comic", name="delete_comic")
     * @param Request $request
     * @return JsonResponse
     * @Method("DELETE")
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction(Request $request)
    {
        $response = new JsonResponse();
        $id = $request->request->has('id') ? $request->request->get('id') : 'noId';
        $comic = $this->getDoctrine()->getManager()->getRepository(Comic::class)->find($id);
        if ($comic != null) {
            $this->container->get('comic.manager.comic')->delete($comic);
            $response->setContent(
                json_encode(
                    [
                        'id' => $id,
                    ]
                )
            );
            $response->setStatusCode(JsonResponse::HTTP_OK);
        } else {
            $response->setContent(
                json_encode(
                    [
                        'error' => 'Invalid data',
                    ]
                )
            );
            $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
        }

        return $response;
    }

    /**
     * @Route("/api/comic",
     *     name="comic_list")
     * @param Request $request
     * @return JsonResponse
     * @Method("GET")
     */
    public function listComicsAction(Request $request)
    {
        $comicRepository = $this->getDoctrine()->getManager()->getRepository(Comic::class);
        $comics = $comicRepository->listComics($request->query->all());

        return new JsonResponse($comics);
    }


}
