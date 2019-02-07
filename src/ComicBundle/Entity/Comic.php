<?php

namespace ComicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comic
 *
 * @ORM\Table(name="comic")
 * @ORM\Entity(repositoryClass="ComicBundle\Repository\ComicRepository")
 */
class Comic implements \JsonSerializable
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
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var Serie
     *
     * @ORM\ManyToOne(targetEntity="Serie",inversedBy="comics")
     * @ORM\JoinColumn(name="serie_id",referencedColumnName="id",nullable=true)
     *
     */
    private $serie;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Charactr",inversedBy="comicsAppearances")
     */
    private $charactrs;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany (targetEntity="LibraryList",mappedBy="comics")
     */
    private $libraryLists;


    /**
     * @var ArrayCollection
     * @ORM\ManyToMany (targetEntity="ToReadList",mappedBy="comics")
     */
    private $toReadLists;

    /**
     * TODO: Añadir somehow
     * @var ArrayCollection
     * @ORM\ManyToMany (targetEntity="ReadList",mappedBy="comics")
     */
    //private $readLists;

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
     * @return Comic
     */
    public function setName(string $name)
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
     * Set number
     *
     * @param integer $number
     *
     * @return Comic
     */
    public function setNumber(int $number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return Serie
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param Serie $serie
     * @return Serie
     */
    public function setSerie(Serie $serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCharactrs()
    {
        return $this->charactrs;
    }

    /**
     * @param ArrayCollection $charactrs
     * @return $this
     */
    public function setCharactrs(ArrayCollection $charactrs)
    {
        $this->charactrs = $charactrs;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLibraryLists()
    {
        return $this->libraryLists;
    }

    /**
     * @param ArrayCollection $libraryLists
     */
    public function setLibraryLists(ArrayCollection $libraryLists)
    {
        $this->libraryLists = $libraryLists;
    }

    /**
     * @return ArrayCollection
     */
    public function getToReadLists()
    {
        return $this->toReadLists;
    }

    /**
     * @param ArrayCollection $toReadLists
     */
    public function setToReadLists(ArrayCollection $toReadLists)
    {
        $this->toReadLists = $toReadLists;
    }

    /**
     * @return ArrayCollection
     */
    /*public function getReadLists()
    {
        return $this->readLists;
    }
*/
    /**
     * @param ArrayCollection $readLists
     */
    /* public function setReadLists(ArrayCollection $readLists)
     {
         $this->readLists = $readLists;
     }
 */

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
        ];
    }
}

