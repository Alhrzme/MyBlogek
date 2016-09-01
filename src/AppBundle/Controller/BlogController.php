<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Form\CommentType;
use AppBundle\Form\PostType;
use Symfony\Bridge\PsrHttpMessage\Tests\Fixtures\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction( Request $request, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bodyText = $post->getBody();
            $resultBodyText = $this->get('textHandler')->makeParagraphMarkup($bodyText);
            $post->setBody($resultBodyText);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('show_post_page', ['id' => $post->getId()] );
        }
        return $this->render('blog/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="create_post_page")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $post = new Post();
        $post->setUser($this->getUser());

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bodyText = $post->getBody();
            $resultBodyText = $this->get('textHandler')->makeParagraphMarkup($bodyText);
            $post->setBody($resultBodyText);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Пост успешно создан');
            return $this->redirectToRoute('show_post_page', ['id' => $post->getId()] );
        }
        return $this->render('blog/new.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_post_page")
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Post $post)
    {
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
}