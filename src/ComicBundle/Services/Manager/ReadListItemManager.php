<?php


namespace ComicBundle\Services\Manager;


use ComicBundle\Entity\Comic;
use ComicBundle\Entity\ReadList;
use ComicBundle\Entity\ReadListItem;
use Doctrine\ORM\EntityManager;

class ReadListItemManager
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
     * @param ReadList $readList
     * @param Comic $comic
     * @return ReadListItem
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(ReadList $readList, Comic $comic)
    {
        $readListItem = new ReadListItem();
        $readListItem->setComic($comic);
        $readListItem->setReadList($readList);
        $date = new \DateTime();
        $date->format('d-m-Y');
        $readListItem->setReadDate($date);
        $this->em->persist($readListItem);
        $this->em->flush();

        return $readListItem;
    }

    /**
     * @param int $readListItemId
     * @return null|object
     */
    public function find(int $readListItemId)
    {
        $readListItem = $this->em->getRepository(ReadListItem::class)->find($readListItemId);

        return $readListItem;
    }


    /**
     * @param ReadListItem $readListItem
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(ReadListItem $readListItem)
    {
        $this->em->remove($readListItem);
        $this->em->flush();
    }

    /**
     * @param ReadListItem $readListItem
     * @param Comic $comic
     * @return bool
     */
    public function isThisComic(ReadListItem $readListItem, Comic $comic)
    {
        return ($readListItem->getComic() === $comic);
    }


}