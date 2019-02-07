<?php

namespace ComicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Charactr
 *
 * @ORM\Table(name="charactr")
 * @ORM\Entity(repositoryClass="ComicBundle\Repository\CharactrRepository")
 */
class Charactr
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
     * @var ArrayCollection
     * @ORM\ManyToMany (targetEntity="Comic",mappedBy="charactrs")
     */
    private $comicsAppearances;

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
     * @return Charactr
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
     * @return ArrayCollection
     */
    public function getComicsAppearances()
    {
        return $this->comicsAppearances;
    }

    /**
     * @param ArrayCollection $comicsAppearances
     * @return Charactr
     */
    public function setComicsAppearances($comicsAppearances)
    {
        $this->comicsAppearances = $comicsAppearances;

        return $this;
    }


}

