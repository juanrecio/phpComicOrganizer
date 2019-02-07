<?php


namespace ComicBundle\Services\Manager;


use ComicBundle\Entity\Comic;
use ComicBundle\Entity\LibraryList;
use ComicBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Repository;
use Doctrine\ORM\Query;



class LibraryListManager
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    /**
     * @param User $user
     * @return LibraryList
     */
    public function create( User $user){

        $library=new LibraryList();
        $library->setUser($user);
        $comics=new ArrayCollection();
        $library->setComics($comics);
        $this->em->persist($library);
        return $library;
    }

    /**
     * @param LibraryList $libraryList
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete (LibraryList $libraryList){
        $this->em->remove($libraryList);
        $this->em->flush();
    }

    /**
     * @param int $libraryListId
     * @return LibraryList|null|object
     */
    public function find ($libraryListId){
        $libraryList= $this->em->getRepository(LibraryList::class)->find($libraryListId);
        return $libraryList;
    }
    /**
     * @param LibraryList $libraryList
     * @param Comic $comic
     * @throws \Doctrine\ORM\OptimisticLockException
     * @return bool
     */
    public function addComic (LibraryList $libraryList, Comic $comic){
        $added=false;
        if (!$this->hasComic($libraryList,$comic)) {
            $added=$libraryList->getComics()->add($comic);
            $this->em->flush();
        }
        return $added;
    }

    /**
     * @param LibraryList $libraryList
     * @param Comic $comic
     * @return bool
     */
    public function hasComic (LibraryList $libraryList, Comic $comic){
        return $libraryList->getComics()->contains($comic);

    }

    /**
     * @param LibraryList $libraryList
     * @param Comic $comic
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeComic(LibraryList $libraryList,Comic $comic){
        $deleted=false;
        if (!$this->hasComic($libraryList,$comic)) {
            $deleted=$libraryList->getComics()->removeElement($comic);
            $this->em->flush();
        }
        return $deleted;
    }




}