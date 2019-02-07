<?php

namespace ComicBundle\Controller;

use ComicBundle\Entity\Comic;
use ComicBundle\Entity\User;
use ComicBundle\Form\AcquireComicType;
use ComicBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/api/user", name="create_user")
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $response = new JsonResponse();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $libraryList = $this->container->get('comic.manager.librarylist')->create($user);
            $toReadList = $this->container->get('comic.manager.toreadlist')->create($user);
            $readList = $this->container->get('comic.manager.readlist')->create($user);
            $user->setLibraryList($libraryList);
            $user->setToReadList($toReadList);
            $user->setReadList($readList);
            $user = $this->container->get('comic.manager.user')->create($user);
            $response->setContent(
                json_encode(
                    [
                        'id' => $user->getId(),
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
            $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
        }

        return $response;

    }

    /**
     * @Route("/api/user", name="delete_user")
     * @param Request $request
     * @return JsonResponse
     * @Method("DELETE")
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction(Request $request)
    {
        $response = new JsonResponse();
        $id = $request->request->has('id') ? $request->request->get('id') : 'noId';
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        if ($user != null) {
            $this->container->get('comic.manager.user')->delete($user);
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
     * @Route("api/acquire", name="acquire")
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Method("POST")
     */
    public function acquireAction(Request $request)
    {
        $response = new JsonResponse();
        $form = $this->createForm(AcquireComicType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($form->get('user')->getData());
            if (!$user instanceof User) {
                $response->setContent(
                    json_encode(
                        [
                            'error' => 'Invalid user',
                        ]
                    )
                );
                $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);

                return $response;
            }
            $comic = $this->getDoctrine()->getManager()->getRepository(Comic::class)->find(
                $form->get('comic')->getData()
            );
            if (!$comic instanceof Comic) {
                $response->setContent(
                    json_encode(
                        [
                            'error' => 'Invalid comic',
                        ]
                    )
                );
                $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);

                return $response;
            }
            if ($this->container->get('comic.manager.librarylist')->addComic($user->getLibraryList(), $comic)) {
                $response->setContent(
                    json_encode(
                        [
                            'UserId' => $user->getId(),
                            'ComicId' => $comic->getId(),
                        ]
                    )
                );
                $response->setStatusCode(JsonResponse::HTTP_OK);
            } else {
                $response->setContent(
                    json_encode(
                        [
                            'error' => 'There was a problem acquiring the comic',
                        ]
                    )
                );
                $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
            }
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

    public function readAction(Request $request)
    {
        $response = new JsonResponse();
    }

    /**
     * @Route("api/user", name="user")
     * @return JsonResponse
     * @param Request $request
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $userRepository = $this->getDoctrine()->getManager()->getRepository(User::class);
        $users = $userRepository->listUsers($request->query->all());

        return new JsonResponse($users);
    }
}
