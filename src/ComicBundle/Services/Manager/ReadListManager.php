<?php

namespace ComicBundle\Services\Manager;


use ComicBundle\Entity\Comic;
use ComicBundle\Entity\ReadList;
use ComicBundle\Entity\ReadListItem;
use ComicBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class ReadListManager{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ReadListManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em=$em;
    }

    /**
     * @param User $user
     * @return ReadList
     */
    public function create(User $user){
        $readList=new ReadList();
        $readList->setUser($user);
        $items=new ArrayCollection();
        $readList->setItems($items);
        $this->em->persist($readList);
        return $readList;
    }

    /**
     * @param ReadList $readList
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete (ReadList $readList){
        $this->em->remove($readList);
        $this->em->flush();
    }

    /**
     * @param int $readListId
     * @return ReadList|null|object
     */
    public function find (int $readListId){
        return $this->em->getRepository(ReadList::class)->find($readListId);
    }

    /**
     * @param ReadList $readList
     * @param Comic $comic
     * @return bool
     */
    public function hasComic(ReadList $readList,Comic $comic){
        $hasComic=false;
        for ($itemrator = $readList->getItems()->getIterator();!$hasComic && $itemrator->valid();$itemrator->next()){
            $hasComic=$itemrator->current()->isThisComic();
        }
        return $hasComic;
    }

    /**
     * @param ReadList $readList
     * @param ReadListItem $readListItem
     * @return bool
     */
    public function addItem(ReadList $readList,ReadListItem $readListItem){
        $added=false;
        if (!$this->hasComic($readList,$readListItem->getComic())){
            $added=$readList->getItems()->add($readListItem);
        }
        return $added;
    }
}

