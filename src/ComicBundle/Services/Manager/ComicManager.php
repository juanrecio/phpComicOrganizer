<?php


namespace ComicBundle\Services\Manager;


use ComicBundle\Entity\Charactr;
use ComicBundle\Entity\Comic;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class ComicManager
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
     * @param Comic $comic
     * @return Comic
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Comic $comic){
        $characters=new ArrayCollection();
        $comic->setCharactrs($characters);
        $this->em->persist($comic);
        $this->em->flush();
        return $comic;
    }

    /**
     * @param int $comicId
     * @return Comic|null|object
     */
    public function find(int $comicId){
        $comic= $this->em->getRepository(Comic::class)->find($comicId);
        return $comic;

    }

    /**
     * @param Comic $comic
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete (Comic $comic){
        $this->em->remove($comic);
        $this->em->flush();
    }

    /**
     * @param Comic $comic
     * @param Character $character
     * @return bool
     */
    public function hasCharactr(Comic $comic,Character $character){
        return $comic->getCharactrs()->contains($character);
    }

    /**
     * @param Comic $comic
     * @param Charactr $charactr
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addCharactr(Comic $comic, Charactr $charactr){
        $added=false;
        if (!$this->hasCharactr($comic,$charactr)) {
            $added=$comic->getCharactrs()->add($charactr);
            $this->em->flush();
        }
        return $added;
    }

    /**
     * @param Comic $comic
     * @param $character
     * @return bool
     */
    public function removeCharacter(Comic $comic,$character){
        $del=false;
        if (!$this->hasCharactr($comic,$character)){
            $del=$comic->getCharactrs()->removeElement($character);
        }
        return $del;
    }

    /**
     * @param Comic $comic
     * @return \Doctrine\ORM\Query
     */
    public function listCharactrs(Comic $comic){
        $comicId=$comic->getId();
        $qb=$this->em->createQueryBuilder();
        $query=$qb->select('c')
            ->from('comic_charactr')
            ->join('characters', 'c')
            ->where($qb->expr()->eq('comic_id' ,$comicId))
            ->getQuery();
        return $query;
    }





}