<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use AppBundle\Form\CommentType;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class BlogController
 * @Route("/blog")
 * @package AppBundle\Controller
 */
class BlogController extends Controller
{
    /**
     * List all posts
     * @Route("/", name="home_page")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository(Post::class)->findAll();

        return $this->render('blog/index.html.twig', array('posts' => $posts));
    }

    /**
     * @Route("/edit/{id}", name="edit_post_page")
     * @param Post $post
     * @param Request $request
     * @return RedirectResponse
     */
    public function editAction( Request $request, Post $post)
    {
        if (!($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            || $post->isAuthor($this->getUser()))) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(PostType::class, $post);
        if ($post->getTags()) {
            $tagString = '';
            foreach ($post->getTags() as $tag) {
                /** @var Tag $tag */
                $tagString .= $tag->getTagName() . ' ';
            }
            $form['tags']->setData($tagString);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $this->handlePostData($post, $form);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('show_post_page', ['id' => $post->getId()] );
        }
        return $this->render('blog/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    private function handlePostData(Post $post, Form $form) {
        if (empty($post->getSummary())) {
            $summary = $this->get('content.handler')->getSummary($post->getBody());
            $post->setSummary($summary);
        }

        if (!empty($tagString = $form['tags']->getData())) {
            $tagArray = $this->get('tag.handler')->tagStringToArray($tagString);
            $post->setTags($tagArray);
        }
        return $post;
    }

    /**
     * @Route("/new", name="create_post_page")
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $post->setUser($this->getUser());

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $this->handlePostData($post, $form);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'flash_bag.new_post.success.message');
            return $this->redirectToRoute('show_post_page', ['id' => $post->getId()] );
        }
        return $this->render('blog/new.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_post")
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Post $post)
    {
        if (!($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            || $post->isAuthor($this->getUser()))) {
            throw $this->createAccessDeniedException();
        }
        $entityManager = $this->getDoctrine()->getManager();
        $comments = $post->getComments();
        foreach ($comments as $comment) {
            $entityManager->remove($comment);
        }
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('home_page');
    }

    /**
     * @Route("/deleteComment/{id}/{postId}", name="delete_comment")
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCommentAction(Comment $comment, $postId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('show_post_page', [
            'id' => $postId
        ]);
    }

    /**
     * @Method("POST")
     * @Route("/comment/new/{id}", name="comment_new")
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addCommentAction(Request $request, Post $post)
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCreatedAt(new \DateTime());
            $comment->setUser($this->getUser());
            $comment->setPost($post);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('show_post_page', [
            'id' => $post->getId()
        ]);
    }

    /**
     * Show post by id
     * @Route("/post/{id}", name="show_post_page")
     * @param Post $post
     * @ParamConverter("post", class="AppBundle:Post", options={"repository_method" = "getPostWithComments"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPostAction(Post $post)
    {
        $commentForm = $this->createForm(CommentType::class, null, [
            'action' => $this->generateUrl('comment_new', ['id' => $post->getId()])
        ]);
        return $this->render('blog/show_post.html.twig', [
            'post' => $post,
            'form' => $commentForm->createView()
        ]);
    }

    /**
     * @Route("/addRate", name="add_rate")
     * @return int
     * @param string("post"|"comment") $entityString
     * @param int $id
     * @return int
     */
    public function addRateAction($entityString, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        if ($entityString == 'post') {
            $repository = $entityManager->getRepository(Post::class);
        } else {
            $repository = $entityManager->getRepository(Comment::class);
        }
        $entity = $repository->find($id);
        $entity->setRate($entity->getRate() + 1);
        $entityManager->persist($entity);
        $entityManager->flush();
        return $entity->getRate();
    }
}