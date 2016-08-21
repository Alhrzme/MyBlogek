<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post {

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    private $postId;
    /**
     * Assert\NotBlank()
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
     * @ORM\Column(type="integer")
     */
    private $createdByUserId;

    /**
     * @return mixed
     */
    public function getCreatedByUserId() {
        return $this->createdByUserId;
    }

    /**
     * @param mixed $createdByUserId
     */
    public function setCreatedByUserId($createdByUserId) {
        $this->createdByUserId = $createdByUserId;
    }

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
     * Set postId
     *
     * @param integer $postId
     * @return Post
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * Get postId
     *
     * @return integer 
     */
    public function getPostId()
    {
        return $this->postId;
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
}
