<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Tag
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="TagRepository")
 * @ORM\Table(name="tags")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable()
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
     * Hook softdeleteable behavior
     * deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntity;

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