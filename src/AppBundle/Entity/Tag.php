<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="TagRepository")
 * @ORM\Table(name="tags")
 */
class Tag
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Post", inversedBy="tags", cascade={"persist"})
     */
    private $posts;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $tagName;

    public function __construct() {
        $this->posts = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPosts() {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts) {
        $this->posts = $posts;
    }

    /**
     * @return string
     */
    public function getTagName() {
        return $this->tagName;
    }

    /**
     * @param string $tagName
     */
    public function setTagName($tagName) {
        $this->tagName = $tagName;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }
}