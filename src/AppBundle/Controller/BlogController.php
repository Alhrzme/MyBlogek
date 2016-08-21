<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/edit/{postId}", name="edit_post_page")
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

            return $this->redirectToRoute('show_post_page', ['postId' => $post->getPostId()] );
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
        $post = new Post();
        $post->setCreatedByUserId(1);

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
            return $this->redirectToRoute('show_post_page', ['postId' => $post->getPostId()] );
        }
        return $this->render('blog/new.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{postId}", name="delete_post_page")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Post $post)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('admin_post_index');
    }

    /**
     * Show post by id
     * @Route("/post/{postId}", name="show_post_page")
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPostAction(Post $post)
    {
        return $this->render('blog/show_post.html.twig', [ 'post' => $post]);
    }
}