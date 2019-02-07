<?php

namespace ComicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ReadList
 *
 * @ORM\Table(name="read_list")
 * @ORM\Entity(repositoryClass="ComicBundle\Repository\ReadListRepository")
 */
class ReadList implements \JsonSerializable
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ReadListItem", mappedBy="id")
     *
     */
    private $items;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User", mappedBy="libraryList")
     */
    private $user;

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
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param ReadListItem[] $items
     * @return ReadList
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return ReadList
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }


    /**
     * TODO: mostar userId
     * TODO:listar readListItems?
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
        ];
    }
}

