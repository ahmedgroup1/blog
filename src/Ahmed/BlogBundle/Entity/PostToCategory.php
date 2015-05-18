<?php

namespace Ahmed\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostToCategory
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ahmed\BlogBundle\Entity\PostToCategoryRepository")
 */
class PostToCategory
{
     /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="post", inversedBy="postToCategories")
    * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
    */
    private $post;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="postToCategories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

   
    
     /**
     * Get post
     *
     * @return post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set post
     *
     * @param post $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}
