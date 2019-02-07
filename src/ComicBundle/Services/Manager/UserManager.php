<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 16/02/18
 * Time: 15:24
 */

namespace ComicBundle\Services\Manager;


use ComicBundle\Entity\LibraryList;
use ComicBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class UserManager
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @return User
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(User $user)
    {
        $this->delete($user);
        $this->em->flush();
    }


}