<?php

namespace ComicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * LibraryList
 *
 * @ORM\Table(name="library_list")
 * @ORM\Entity(repositoryClass="ComicBundle\Repository\LibraryListRepository")
 */
class LibraryList implements \JsonSerializable
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
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User", mappedBy="libraryList")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="Comic",inversedBy="libraryLists")
     * @ORM\JoinTable(name="library_comics",
     *      joinColumns={@ORM\JoinColumn(name="library_list_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="comic_id", referencedColumnName="id")}
     *      )
     * @var ArrayCollection
     */
    private $comics;


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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return LibraryList
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getComics()
    {
        return $this->comics;
    }

    /**
     * @param ArrayCollection $comics
     * @return LibraryList
     */
    public function setComics($comics)
    {
        $this->comics = $comics;

        return $this;
    }

    /**
     * TODO: listar comics
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'userId' => $this->user->getId(),
        ];
    }


}

