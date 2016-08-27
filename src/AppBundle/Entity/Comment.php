<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="comments")
 */
class Comment {
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    private $commentId;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="empty_comment_body")
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate = 0;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    /**
     * @var Post
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="postId", referencedColumnName="id")
     */
    private $post;

    /**
     * @return mixed
     */
    public function getCommentId() {
        return $this->commentId;
    }

    /**
     * @param mixed $commentId
     */
    public function setCommentId($commentId) {
        $this->commentId = $commentId;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body) {
        $this->body = $body;
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
     * @return mixed
     */
    public function getRate() {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate) {
        $this->rate = $rate;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return Post
     */
    public function getPost() {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost($post) {
        $this->post = $post;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user) {
        $this->user = $user;
    }
}
