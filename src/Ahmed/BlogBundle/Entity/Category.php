<?php

namespace Ahmed\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ahmed\BlogBundle\Entity\CategoryRepository")
 */
class Category {

    /**
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="categories")
     * */
    private $posts;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Add posts
     *
     * @param \Ahmed\BlogBundle\Entity\Post $posts
     */
    public function addposts(\Ahmed\BlogBundle\Entity\Post $posts) {
        $item->addCategory($this);
        $this->posts[] = $posts;
    }

    /**
     * Get posts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getposts() {
        return $this->posts;
    }
    
        public function __construct() {
        $this->posts = new ArrayCollection();
    }

}
