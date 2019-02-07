<?php


namespace ComicBundle\Services\Manager;


use ComicBundle\Entity\Comic;
use ComicBundle\Entity\ToReadList;
use ComicBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Repository;
use Doctrine\ORM\Query;



class ToReadListManager
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
     * @return ToReadList
     */
    public function create( User $user){

        $toReadList=new ToReadList();
        $toReadList->setUser($user);
        $comics=new ArrayCollection();
        $toReadList->setComics($comics);
        $this->em->persist($toReadList);
        return $toReadList;
    }

    /**
     * @param ToReadList $toReadList
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete (ToReadList $toReadList){
        $this->em->remove($toReadList);
        $this->em->flush();
    }

    /**
     * @param int $toReadListId
     * @return ToReadList|null|object
     */
    public function find ($toReadListId){
        $toReadList= $this->em->getRepository(ToReadList::class)->find($toReadListId);
        return $toReadList;
    }
    /**
     * @param ToReadList $toReadList
     * @param Comic $comic
     * @throws \Doctrine\ORM\OptimisticLockException
     * @return bool
     */
    public function addComic (ToReadList $toReadList, Comic $comic){
        $added=false;
        if (!$this->hasComic($toReadList,$comic)) {
            $added=$toReadList->getComics()->add($comic);
            $this->em->flush();
        }
        return $added;
    }

    /**
     * @param ToReadList $toReadList
     * @param Comic $comic
     * @return bool
     */
    public function hasComic (ToReadList $toReadList, Comic $comic){
        return $toReadList->getComics()->contains($comic);

    }

    /**
     * @param ToReadList $toReadList
     * @param Comic $comic
     * @return bool|false|int|null|string
     */
    public function getPosition (ToReadList $toReadList, Comic $comic){
        $position=null;
        if ($this->hasComic($toReadList,$comic)){
            $position=$toReadList->getComics()->indexOf($comic);
        }
        return $position;
    }

    /**
     * TODO comprobar que set no borra, solo inserta
     * @param ToReadList $toReadList
     * @param Comic $comic
     * @param int $position
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insertAt (ToReadList $toReadList,Comic $comic,int $position){
        $inserted=false;
        if ($position>=0 &&
            $position<=($toReadList->getComics()->count()) &&
            !$this->hasComic($toReadList,$comic)){
            $toReadList->getComics()->set($position,$comic);
            $inserted=true;
            $this->em->flush();
        }
        return $inserted;

    }

    /**
     * @param ToReadList $toReadList
     * @param Comic $comic
     * @param int $position
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function changePosition (ToReadList $toReadList,Comic $comic,int $position){
        $changed=false;
        $prevPos=$this->getPosition($toReadList,$comic);
        if ($prevPos!=null && $this->removeComic($toReadList,$comic))
        {
            $changed=$this->insertAt($toReadList,$comic,$position);
            if (!$changed){
                $this->insertAt($toReadList,$comic,$prevPos);
            }
        }
        return $changed;
    }

    /**
     * @param ToReadList $toReadList
     * @param Comic $comic
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeComic(ToReadList $toReadList,Comic $comic){
        $deleted=false;
        if (!$this->hasComic($toReadList,$comic)) {
            $deleted=$toReadList->getComics()->removeElement($comic);
            $this->em->flush();
        }
        return $deleted;
    }

    /**
     * TODO comprobar si funciona la posición,sino intentar con setParameter
     * @param ToReadList $toReadList
     * @return array
     */
    public function listComics(ToReadList $toReadList){
        $toReadListId=$toReadList->getId();
        $comicRepository=$this->em->getRepository(Comic::class);
        $qb=$this->em->createQueryBuilder();
        $query=$qb->select('c.id')
            ->addSelect($this->getPosition($toReadList,$comicRepository->find('c.id')))
            ->from('ComicBundle:ToReadList','t')
            ->setParameter('toReadListId',$toReadListId)
            ->innerJoin('l.comics','c')
            ->where('t.id = :toReadList')
            ->getQuery()->getResult();
        return $query;
    }

    /**
     * @return array
     */
    public function listToReadList(){
        $qb=$this->em->createQueryBuilder();
        $query=$qb->select('l.id')->from('ComicBundle:ToReadList', 'l')->getQuery()->getResult();
        return $query;
    }


}