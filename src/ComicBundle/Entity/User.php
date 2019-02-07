<?php

namespace ComicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ComicBundle\Repository\UserRepository")
 */
class User implements \JsonSerializable
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="ToReadList", inversedBy="user")
     * @ORM\JoinColumn(name="toReadList_id", referencedColumnName="id")
     * @var ToReadList
     */
    private $toReadList;

    /**
     * @ORM\OneToOne(targetEntity="ReadList", inversedBy="user")
     * @ORM\JoinColumn(name="readList_id", referencedColumnName="id")
     * @var ReadList
     */
    private $readList;

    /**
     * @ORM\OneToOne(targetEntity="LibraryList", inversedBy="user")
     * @ORM\JoinColumn(name="libraryList_id", referencedColumnName="id")
     * @var LibraryList
     */
    private $libraryList;


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
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ToReadList
     */
    public function getToReadList()
    {
        return $this->toReadList;
    }

    /**
     * @param mixed $toReadList
     *
     * @return User
     */
    public function setToReadList($toReadList)
    {
        $this->toReadList = $toReadList;
        return $this;
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
     *
     * @return User
     */
    public function setReadList($readList)
    {
        $this->readList = $readList;
        return $this;
    }

    /**
     * @return LibraryList
     */
    public function getLibraryList()
    {
        return $this->libraryList;
    }

    /**
     * @param LibraryList $libraryList
     * @return User
     */
    public function setLibraryList($libraryList)
    {
        $this->libraryList = $libraryList;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'libraryList' => $this->getLibraryList()? $this->getLibraryList()->getId(): null,
            'toReadList' => $this->getReadList()? $this->getReadList()->getId(): null,
            'readList' => $this->getToReadList()? $this->getToReadList()->getId(): null
        ];
    }

}

