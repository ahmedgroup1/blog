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
     * @ORM\OneToMany(targetEntity="PostToCategory", mappedBy="category")
     */
    private $postToCategories;

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

  

    public function __construct() {
        $this->postToCategories = new ArrayCollection();
    }

    public function getPostToCategories() {
        return $this->postToCategories;
    }

    public function addPostToCategories($postToCategories) {
        $this->postToCategories[] = $postToCategories;
    }

    /**
     * Add postToCategories
     *
     * @param  PostToCategory $postToCategories
     * @return Category
     */
    public function addPostToCategory(PostToCategory $postToCategories) {
        $this->postToCategories[] = $postToCategories;

        return $this;
    }

    /**
     * Remove postToCategories
     *
     * @param PostToCategory $postToCategories
     */
    public function removePostToCategory(PostToCategory $postToCategories) {
        $this->postToCategories->removeElement($postToCategories);
    }

}
