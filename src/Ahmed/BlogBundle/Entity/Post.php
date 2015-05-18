<?php

namespace Ahmed\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ahmed\BlogBundle\Entity\PostRepository")
 */
class Post {

    /**
     * @ORM\OneToMany(targetEntity="PostToCategory", mappedBy="post")
     * @ORM\OrderBy({"ordering" = "ASC"})
     */
    private $postToCategories;
    private $categories;

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
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateUpdated", type="datetime")
     */
    private $dateUpdated;

    /**
     * @var integer
     *
     * @ORM\Column(name="author", type="integer")
     */
    private $author;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Post
     */
    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     * @return Post
     */
    public function setDateUpdated($dateUpdated) {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime 
     */
    public function getDateUpdated() {
        return $this->dateUpdated;
    }

    /**
     * Set author
     *
     * @param integer $author
     * @return Post
     */
    public function setAuthor($author) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return integer 
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->postToCategories = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    /**
     * Get courceToCategoies
     *
     * @return List<PostToCategory>
     */
    public function getPostToCategories() {
        return $this->postToCategories;
    }

    /**
     * Add postToCategories
     *
     * @param PostToCategory
     */
    public function addPostToCategories(PostToCategory $postToCategories) {
        $postToCategories->setPost($this);
        $this->postToCategories[] = $postToCategories;
    }

    /**
     * Add postToCategories
     *
     * @param PostToCategory
     */
    
    public function setPostToCategories(\Ahmed\BlogBundle\Entity\PostToCategory $postToCategories) {
        $postToCategories->setPost($this);
        $this->postToCategories[] = $postToCategories;
        return $this;
    }

    /**
     * Add postToCategories
     *
     * @param  \TA\CurriculumBundle\Entity\PostToCategory $postToCategories
     * @return Post
     */
    public function addPostToCategory(PostToCategory $postToCategories) {
        $this->postToCategories[] = $postToCategories;

        return $this;
    }

    /**
     * Remove postToCategories
     *
     * @param \TA\CurriculumBundle\Entity\PostToCategory $postToCategories
     */
    public function removePostToCategory(PostToCategory $postToCategories) {
        $this->postToCategories->removeElement($postToCategories);
    }

}
