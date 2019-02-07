<?php

namespace ComicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * ReadListItem
 *
 * @ORM\Table(name="read_list_item")
 * @ORM\Entity(repositoryClass="ComicBundle\Repository\ReadListItemRepository")
 */
class ReadListItem implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="readDate", type="date")
     */
    private $readDate;

    /**
     * @var ReadList
     * @ORM\ManyToOne(targetEntity="ReadList", inversedBy="items")
     * @ORM\JoinColumn(name="read_list_id", referencedColumnName="id")
     */
    private $readList;

    /**
     * @var Comic
     *
     * @ORM\ManyToOne(targetEntity="Comic")
     * @ORM\JoinColumn(name="comic_id", referencedColumnName="id")
     */
    private $comic;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set readDate
     *
     * @param \DateTime $readDate
     *
     * @return ReadListItem
     */
    public function setReadDate(\DateTime $readDate)
    {
        $this->readDate = $readDate;

        return $this;
    }

    /**
     * Get readDate
     *
     * @return \DateTime
     */
    public function getReadDate()
    {
        return $this->readDate;
    }

    /**
     * @return ReadList
     */
    public function getReadList()
    {
        return $this->readList;
    }

    /**
     * @param ReadList $readList
     * @return ReadListItem
     */
    public function setReadList($readList)
    {
        $this->readList = $readList;

        return $this;
    }

    /**
     * @return Comic
     */
    public function getComic()
    {
        return $this->comic;
    }

    /**
     * @param Comic $comic
     * @return ReadListItem
     */
    public function setComic($comic)
    {
        $this->comic = $comic;

        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'comidId' => $this->getComic()->getId(),
            'date' => $this->getReadDate(),
        ];
    }

}

