<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findAll();

        return $this->render('post/post-listing.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Entity Manager: interact with the DB
            $em = $this->getDoctrine()->getManager();

            // Final DB statement
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post has been created successfully!');

            return $this->redirectToRoute('post.index');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete", name="delete")
     * @param Post $post
     * @return RedirectResponse
     */
    public function delete(Post $post)
    {
        // Entity Manager: interact with the DB
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);

        // Final DB statement
        $em->flush();

        $this->addFlash('success', 'Post has been removed successfully!');

        return $this->redirectToRoute('post.index');
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }
}