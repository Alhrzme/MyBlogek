<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Comment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PostRepository")
 * @ORM\Table(name="posts")
 */
class Post {

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->comments = new ArrayCollection();
    }
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1023)
     * @Assert\Length(min=10, minMessage="too_shory_post_content")
     */
    private $body;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string")
     */
    private $summary;

    /**
     * @return mixed
     */
    public function getSummary() {
        return $this->summary;
    }

    /**
     * @param mixed $summary
     */
    public function setSummary($summary) {
        $this->summary = $summary;
    }

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }


    /**
     * @param integer $id
     * @return Post
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    private $comments;

    /**
     * Set body
     *
     * @param string $body
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Add comments
     *
     * @param \AppBundle\Entity\Comment $comment
     * @return Post
     * @internal param \AppBundle\Entity\Comment $comments
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setPost($this);
        return $this;
    }

    /**
     * Remove comments
     *
     * @param Comment $comments
     */
    public function removeComment(Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Post
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
